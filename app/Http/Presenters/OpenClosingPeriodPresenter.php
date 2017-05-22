<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use PDF;

class OpenClosingPeriodPresenter extends PresenterCore
{
    /**
     * Loads the Open/Close Period page on front-end
     * @return Laravel Blade View
     */
    public function index(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $reportsPresenter = PresenterFactory::getInstance('Reports');

        $this->view->companyCode = $reportsPresenter->getCompanyCode();
        $this->view->months = $this->getMonths();
        $this->view->years = $this->getYears();
        $this->view->reportNavigations = $this->getReportConnectedNavigation();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('open-closing-period',$user_group_id,$user_id);
        return $this->view('index');
    }

    /**
     * Return the filter results using the month,year,navigation_ids and company_code
     * @return json
     */
    public function reports(){
        $data = [
            'navigation_reports' =>  $this->processNavigationReports($this->request->get('navigations_ids'),$this->request->get('month'),$this->request->get('year'),$this->request->get('company_code')),
            'day_limit' => $this->calculateDayLimit($this->request->get('month'),$this->request->get('year'))
        ];

        return response()->json($data);
    }

    /**
     * Gets the report period information
     * @param  {String} company_code
     * @param  {integer} navigation_id [References navigation table]
     * @param  {integer} month
     * @param  {integer} year
     * @return Object
     */
    public function getReportPeriod($company_code,$navigation_id,$month,$year){
        return  \DB::table('periods')
                    ->select( 
                        'id',
                        'company_code',
                        'period_month',
                        'period_year',
                        'period_status'
                    )
                    ->where('company_code','=',$company_code)
                    ->where('period_month','=',$month)
                    ->where('period_year','=',$year)
                    ->where('navigation_id','=',$navigation_id)
                    ->first();
    }

    /**
     * Gets the status of a date of a certain report period information
     * @param  {integer} $period_id [References periods table]
     * @param  {integer} date [e.g. January 31,2016; 31 is the date it references]
     * @return Object
     */
    public function getReportPeriodDateStatus($period_id,$date){
        return  \DB::table('period_dates')
                    ->select( 
                        'period_date_status'
                    )
                    ->where('period_id','=',$period_id)
                    ->where('period_date','=',$date)
                    ->first();
    }

    /**
     * Returns end date of a month
     * @param  {integer} $month
     * @param  {integer} $year
     * @return integer
     */
    public function calculateDayLimit($month,$year){
        if($month == 2) {
            return $year % 4 == 0 ? 29 : 28;
        }

        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            return 31;
        }

        if($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            return 30;
        }
    }

    /**
     * Returns the list of month
     * @return Array
     */
    public function getMonths(){
        return [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
    }

    /**
     * Returns the list of years starting from present year until 2015
     * @return Array
     */
    public function getYears(){
        $years = [];
        for($year = date('Y'); $year >= 2015; $year--){
            $years[$year] = $year;
        }
        return $years;
    }

    /**
     * Returns the list of navigation connected to reports
     * @return Array
     */
    public function getReportConnectedNavigation(){
        $navigations = [
            'Sales & Collection',
            'Van Inventory',
            'Sales Report',
        ];

        return \DB::table('navigation')
                    ->whereIn('name',$navigations)
                    ->orderBy('id')
                    ->lists('name','id');
    }

    /**
     * If certain period is closed
     * @param  {String} company_code
     * @param  {integer} navigation_id [References navigation table]
     * @param  {integer} month
     * @param  {integer} year
     * @return Object
     */
    public function periodClosed($company_code,$navigation_id,$month,$year){
        return  \DB::table('periods')
                    ->select( 
                        'id',
                        'company_code',
                        'period_month',
                        'period_year',
                        'period_status'
                    )
                    ->where('company_code','=',$company_code)
                    ->where('period_month','=',$month)
                    ->where('period_year','=',$year)
                    ->where('navigation_id','=',$navigation_id)
                    ->where('period_status','=','close')
                    ->first();
    }

    /**
     * Get Banned Child Navigations
     * @param  {String} $company_code
     * @return Array
     */
    public function getBannedChildNavigationIds($company_code){
        $child_ids = [11,16,17,18,19,20,26,27,28,37];
        $child_ids[] = $company_code == 1000 ? 13 : 12;
        return $child_ids;
    }

    /**
     * Child Count of Parent
     * @param  {integer} $parent_id   
     * @param  {integer} $company_code
     * @return integer
     */
    public function getChildCount($parent_id,$company_code){
        return \DB::table('navigation')->where('parent_id','=',$parent_id)->whereNotIn('id',$this->getBannedChildNavigationIds($company_code))->count();
    }

    /**
     * Process Navigation Report
     * @param  {integer} $navigation_ids
     * @param  {integer} $month
     * @param  {integer} $year
     * @param  {String} $company_code
     * @return Object
     */
    public function processNavigationReports($navigation_ids,$month,$year,$company_code){
        $day_limit = $this->calculateDayLimit($month,$year);
        $dates = [];

        for($x = 1; $x<= $day_limit; $x++){
            $dates[$x] = 0;
        }

        $navigation_reports =   \DB::table('navigation as parent')
                                    ->select( 
                                        'parent.id as parent_id',
                                        'parent.name as parent_name',
                                        'child.id as child_id',
                                        'child.name as child_name'
                                    )
                                    ->leftJoin('navigation as child', function($join) use ($company_code){
                                        $join
                                            ->on('child.parent_id', '=', 'parent.id')
                                            ->whereNotIn('child.id', $this->getBannedChildNavigationIds($company_code));
                                    })
                                    ->whereIn('parent.id',$navigation_ids)
                                    ->orderBy('parent.id')
                                    ->get();

        $current_parent_name = '';

        foreach ($navigation_reports as $key => $value) {
            $parent_name = $navigation_reports[$key]->parent_name;
            $navigation_reports[$key]->parent_name = '';
            $navigation_reports[$key]->row_span = 0;

            if($current_parent_name != $parent_name){
                $current_parent_name = $parent_name;
                $navigation_reports[$key]->parent_name = $parent_name;
                $navigation_reports[$key]->row_span = $this->getChildCount($navigation_reports[$key]->parent_id,$company_code);
            }

            $navigation_reports[$key]->dates = $dates;

            $navigation_id = !is_null($navigation_reports[$key]->child_id) ? $navigation_reports[$key]->child_id : $navigation_reports[$key]->parent_id;
            $report_period = $this->getReportPeriod($company_code,$navigation_id,$month,$year);

            $navigation_reports[$key]->period_id = !empty($report_period) ? $report_period->id : null;
            $navigation_reports[$key]->company_code = !empty($report_period) ? $report_period->company_code : null;
            $navigation_reports[$key]->period_month = !empty($report_period) ? $report_period->period_month : null;
            $navigation_reports[$key]->period_year = !empty($report_period) ? $report_period->period_year : null;
            $navigation_reports[$key]->period_status = !empty($report_period) ? $report_period->period_status : 0;

            if(!is_null($navigation_reports[$key]->period_id)){
                foreach ($navigation_reports[$key]->dates as $date => $value2) {
                    $navigation_reports[$key]->dates[$date] = !empty($this->getReportPeriodDateStatus($value->period_id,$date)) ? $this->getReportPeriodDateStatus($value->period_id,$date)->period_date_status : 0;
                }
            }
        }

        return $navigation_reports;
    }

    /**
     * Print Report Navigation Period
     * @return Streamed PDF
     */
    public function printReport(){
        $data = [
            'report_data'  => $this->processNavigationReports(explode(',', $this->request->get('navigations_ids')),$this->request->get('month'),$this->request->get('year'),$this->request->get('company_code')),
            'limit_day'    => $this->request->get('limit_day'),
            'period_label' => $this->request->get('period_label'),
            'generated_by' => auth()->user()->firstname . ' '. auth()->user()->lastname
        ];

        $pdf = PDF::loadView('OpenClosingPeriod.print', $data)->setPaper('legal', 'landscape');

        return $pdf->download('period-' . str_replace(' ', '',$this->request->get('period_label')) . '.pdf');
    }
}