<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;
use App\Factories\ModelFactory;

class ReversalPresenter extends PresenterCore
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->tableHeaders = $this->getSummaryReversalColumns();
    	$this->view->areas = $reportsPresenter->getArea(true);
    	$this->view->customers = $reportsPresenter->getCustomer();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('summary-of-reversal',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','summary-of-reversal')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Summary of Reversal'
        ]);

    	return $this->view('index');
    }


    /**
     * Get cash payments
     * @return string[][]
     */
    public function getSummaryReversalColumns()
    {
    	$headers = [
    			['name'=>'Reversal No.','sort'=>'revision_number'],
    			['name'=>'Reversal Date','sort'=>'created_at'],
    			['name'=>'Type of Report','sort'=>'report_type'],
    			['name'=>'Username','sort'=>'username'],
    			['name'=>'Original','sort'=>'before'],
    			['name'=>'Edited','sort'=>'value'],
    			['name'=>'Reason of Reversal','sort'=>'comment'],    			
    	];
    
    	return $headers;
    }
    
    
    /**
     * Get Cash Payment Select Columns
     * @return string[][]
     */
    function getSummaryReversalSelectColumns()
    {
    	return [
    			'revision_number',
    			'created_at',
    			'report_type',
    			'username',
    			'before',
    			'value',
    			'comment'    			
    	];
    }
    
    /**
     * get Cash Payment Filter Data
     * @return string[]|unknown[]
     */
    public function getSummaryReversalFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$report = $this->request->get('report') ? get_reports()[$this->request->get('report')] : 'All';    	
    	$branch = $this->request->get('branch') ? $reportPresenter->getArea()[$this->request->get('branch')] : 'All';
    	$user = $this->request->get('updated_by') ? get_users(false)[$this->request->get('updated_by')] : 'All';
    	$mDate = ($this->request->get('created_at_from') && $this->request->get('created_at_to')) ? $this->request->get('created_at_from').' - '.$this->request->get('created_at_to') : 'All';    	
    	$revision = $this->request->get('revision') ?  $this->request->get('revision') : 'All';
    	
    	$filters = [
    			'Report' => $report,
    			'Branch' => $branch,
    			'User' => $user,
    			'Modified Date' => $mDate,
    			'Revision' => $revision,    			    		
    	];    	
    
    	return $filters;
    }
    
    /**
     * Get summary of reversal report
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSummaryReversalReport()
    {
    	$prepare = $this->getPreparedSummaryReversal();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','summary-of-reversal')->value('id'),
            'action_identifier' => '',
            'action'            => 'done loading Summary of Reversal data'
        ]);

    	return response()->json($data);
    }
    
    /**
     * Get prepared statement summary of reversal
     * @return unknown
     */
    public function getPreparedSummaryReversal()
    {
    	$select = '
    			   report_revisions.revision_number,
    			   table_logs.created_at,
    			   table_logs.report_type,
    			   CONCAT(user.firstname,\' \',user.lastname) username,
    			   table_logs.before,
    			   table_logs.value,
    		 	   table_logs.comment
    			';
    	
    	$prepare = \DB::table('table_logs')
    					->selectRaw($select)
    					->leftJoin('report_revisions','table_logs.id','=','report_revisions.table_log_id')
				    	->leftJoin('user','user.id','=','table_logs.updated_by');				    	
    	    	
    	
    	$reportFilter = FilterFactory::getInstance('Select');
    	$prepare = $reportFilter->addFilter($prepare,'report',
    			function($self, $model){
    				return $model->where('report_revisions.report',$self->getValue());
    			});
    	
    	$branchFilter = FilterFactory::getInstance('Text');
    	$prepare = $branchFilter->addFilter($prepare,'branch',
    			function($self, $model){
    				return $model->where('user.location_assignment_code',$self->getValue());
    			});
    	 
    	$userFilter = FilterFactory::getInstance('Select');
    	$prepare = $userFilter->addFilter($prepare,'updated_by');
    	 
    	$mDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $mDateFilter->addFilter($prepare,'created_at');
    	 
    	$revNumFilter = FilterFactory::getInstance('Date');
    	$prepare = $revNumFilter->addFilter($prepare,'revision',
    			function($self, $model){
    				return $model->where('report_revisions.revision_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('table_logs.created_at','desc');
    	}

    	$prepare->whereNull('user.deleted_at');
    	
    	return $prepare;
    }
}
