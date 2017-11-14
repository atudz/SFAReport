<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;
use App\Factories\FilterFactory;

class InvoicePresenter extends PresenterCore
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
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->tableHeaders = $this->getInvoiceSeriesColumns();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('invoice-series-mapping',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Invoice Series Mapping'
        ]);

        return $this->view('invoice');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->invoice = ModelFactory::getInstance('Invoice');
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('invoice-series-mapping',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Invoice Series Mapping (Add)'
        ]);

    	return $this->view('create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->invoice = ModelFactory::getInstance('Invoice')->find($id);
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('invoice-series-mapping',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Invoice Series Mapping (Edit)'
        ]);

    	return $this->view('create');
    }
    
    /**
     * Get Invocie Series data report
     * @return \App\Core\PaginatorCore
     */
    public function getInvoiceSeriesReport()
    {
    	$prepare = $this->getPreparedInvoiceSeries();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    	 
    	$reference = '';
    	if($data['total'])
    	{
    		foreach($data['records'] as $row)
    		{
    			$reference = $row->id;
    			break;
    		}
    	}
    	$data['id'] = $reference;

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => '',
            'action'            => 'done loading Invoice Series Mapping data'
        ]);

    	return response()->json($data);
    }
    
    /**
     * Get prepared invoice series query
     * @return unknown
     */
    public function getPreparedInvoiceSeries()
    {    	
    	$select = '
    			 invoice.id,
    			 app_area.area_name,
    			 invoice.salesman_code,
    			 app_salesman.salesman_name,
    			 invoice.invoice_start,
    			 invoice.invoice_end,
    			 invoice.created_at,
    			 IF(invoice.status=\'A\',\'Active\',\'Inactive\') status
    			';
    	
    	$prepare = \DB::table('invoice')
				    	->selectRaw($select)
				    	->leftJoin('app_salesman','app_salesman.salesman_code','=','invoice.salesman_code')				    	
				    	->leftJoin('app_area','app_area.area_code','=','invoice.area_code');
    	
    	if($this->isSalesman())
    	{
    		$prepare->where('invoice.salesman_code',auth()->user()->salesman_code);
    	}
    	else
    	{
    		$salesmanFilter = FilterFactory::getInstance('Select');
    		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	}
    	
    	$assignDateFilter = FilterFactory::getInstance('Date');
    	$prepare = $assignDateFilter->addFilter($prepare,'created_at');
    		 
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area_code',
    			function($self, $model){
    				return $model->where('app_area.area_code',$self->getValue());
    			});
    	
    	$statusFilter = FilterFactory::getInstance('Select');
    	$prepare = $statusFilter->addFilter($prepare,'status');
    	
    	$invoiceFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceFilter->addFilter($prepare,'invoice_date',function($self, $model){
    		return $model->whereBetween('txn_sales_order_header.so_date',$self->formatValues($self->getValue()));
    	});
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('invoice.created_at','desc');
    	}
    	
    	$prepare->whereNull('deleted_at');
    	
    	//     	if(!$this->hasAdminRole() && auth()->user())
    	//     	{
    	//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
		//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
		//     		$prepare->whereIn('salesman_area.area_code',$codes);
      //     	}
      
    	return $prepare;
    }
    
    /**
     * Get invoice series mapping table columns
     */
    public function getInvoiceSeriesColumns($exludeActions=false)
    {
    	$columns = [
    			['name'=>'Area','sort'=>'area_name'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Invoice Series From','sort'=>'invoice_start'],
    			['name'=>'Invoice Series To','sort'=>'invoice_end'],
    			['name'=>'Date Assigned','sort'=>'created_at'],
    			['name'=>'Status','sort'=>'status'],
    			['name'=>'Action']
    	];
    	
    	if($exludeActions)
    		array_pop($columns);
    	return $columns;
    }
    
    
    /**
     * Get Invocie series select columns
     * @return string[][]
     */
    function getInvoiceSeriesSelectColumns()
    {
    	return [
    			'area_name',
    			'salesman_code',
    			'salesman_name',
    			'invoice_start',
    			'invoice_end',
    			'created_at',
    			'status',    			
    	];
    }
    
    /**
     * Get Invoice series filter  data
     * @return string[]|unknown[]
     */
    public function getInvoiceSeriesFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area_code') ? $reportPresenter->getArea()[$this->request->get('area_code')] : 'All';    	
    	$assignDate = $this->request->get('date_assigned_from') ? $this->request->get('date_assigned_from') : 'All';
    	$status = $this->request->get('status') ? statuses()[$this->request->get('status')] : 'All'; 
    	
    	$filters = [
    			'Salesman' => $salesman,
    			'Area' => $area,
    			'Date Assigned' => $assignDate,
    			'Status' => $status
    	];
    	
    	return $filters;
    }
    
}
