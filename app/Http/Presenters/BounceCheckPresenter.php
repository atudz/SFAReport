<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use DB;
use App\Factories\FilterFactory;
use App\Factories\ModelFactory;

class BounceCheckPresenter extends PresenterCore
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
    	$this->view->tableHeaders = $this->getBounceCheckColumns();
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->customers = $reportsPresenter->getCustomer();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('bounce-check-report',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action'        => 'visit Bounce Check Report'
        ]);

    	return $this->view('index');
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
    	$this->view->tableHeaders = $this->getBounceCheckColumns(true);
    	$this->view->bounceCheck = ModelFactory::getInstance('BounceCheck');
    	$this->view->payments = 0;
    	$this->view->txn_code = generate_txn_code();
    	$this->view->max_count = 0;
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('bounce-check-report',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action'        => 'visit Bounce Check Report (Add)'
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
    	$this->view->tableHeaders = $this->getBounceCheckColumns(true);
    	$bounceCheck = ModelFactory::getInstance('BounceCheck')->find($id);    	
    	$this->view->bounceCheck = $bounceCheck;
    	$txnNumber = $bounceCheck->txn_number;
    	if(false !== strpos($txnNumber,'-'))
    		$txnNumber = explode('-', $txnNumber)[0];
    	$this->view->payments = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$txnNumber.'%')->sum('payment_amount');
    	$this->view->txn_code = $bounceCheck ? $bounceCheck->txn_number : generate_txn_code();
    	$max = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$bounceCheck->txn_number.'%')->max('txn_number');
    	$count = 0;
    	if(false !== strpos($max,'-'))
    		$count = explode('-', $max)[1];
    	$this->view->max_count = $count;
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('bounce-check-report',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action'        => 'visit Bounce Check Report (Edit)'
        ]);

    	return $this->view('create');
    }
    
    /**
     * Get Bounce Check report
     * @return \App\Core\PaginatorCore
     */
    public function getBounceCheckReport()
    {
    	$prepare = $this->getPreparedBounceCheck();
    	$data['records'] = $prepare->get();
    	$data['total'] = count($data['records']);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action'        => 'finished loading Bounce Check Report data'
        ]);

    	return response()->json($data);
    }
    
    /**
     * Get prepared bounce check report
     * @return unknown
     */
    public function getPreparedBounceCheck()
    {
    	$select = '
    			bounce_check.id,
    			bounce_check.txn_number,
    			app_salesman.salesman_name,
    			CONCAT(jr.lastname,\', \',jr.firstname) jr_salesman,
    			app_area.area_name,
    			app_customer.customer_name,
    			bounce_check.original_amount,
    			bounce_check.balance_amount,
    			bounce_check.payment_amount,
    			bounce_check.payment_date,
    			bounce_check.remarks,
    			bounce_check.dm_number,
    			bounce_check.dm_date,
    			bounce_check.invoice_number,
    			bounce_check.invoice_date,
    			bounce_check.bank_name,
    			bounce_check.cheque_number,
    			bounce_check.cheque_date,
    			bounce_check.account_number,
    			bounce_check.reason,
    			CONCAT(creator.firstname,\' \',creator.lastname) username
    			';
    	 
    	$prepare = \DB::table('bounce_check')
				    	->selectRaw($select)
				    	->leftJoin('app_salesman','app_salesman.salesman_code','=','bounce_check.salesman_code')
				    	->leftJoin('app_customer','app_customer.customer_code','=','bounce_check.customer_code')
				    	->leftJoin('app_area','app_area.area_code','=','bounce_check.area_code')
				    	->leftJoin('user as jr','jr.id','=','bounce_check.jr_salesman_id')
				    	->leftJoin('user as creator','creator.id','=','bounce_check.created_by');
    	 
    	if($this->isSalesman())
    	{
    		$prepare->where('bounce_check.salesman_code',auth()->user()->salesman_code);
    	}
    	else
    	{
    		$salesmanFilter = FilterFactory::getInstance('Select');
    		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	}
    	 
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area_code');
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code');
    	
    	$txnCodeFilter = FilterFactory::getInstance('Text');
    	$prepare = $txnCodeFilter->addFilter($prepare,'txn_number');
    	
    	$reasonFilter = FilterFactory::getInstance('Text');
    	$prepare = $reasonFilter->addFilter($prepare,'reason');
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('Date');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date');
    	
    	$dmDateFilter = FilterFactory::getInstance('Date');
    	$prepare = $dmDateFilter->addFilter($prepare,'dm_date');
    	
    	 
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('bounce_check.created_at','desc');
    	}
    		 
    	$prepare->whereNull('bounce_check.deleted_at');
    		 
    	//     	if(!$this->hasAdminRole() && auth()->user())
    	//     	{
    	//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
    	//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
    	//     		$prepare->whereIn('salesman_area.area_code',$codes);
    	//     	}
    
    	return $prepare;
    }
    
    /**
     * get Bounce check table columns
     * @param string $export
     */
    public function getBounceCheckColumns($export=false)
    {
    	$columns = [
    			['name'=>'Transaction No.','sort'=>'txn_number'],
    			['name'=>'Sr. Salesman','sort'=>'salesman_name'],
    			['name'=>'Jr. Salesman','sort'=>'jr_salesman'],
    			['name'=>'Salesman Area','sort'=>'area_name'],
    			['name'=>'Customer','sort'=>'customer_name'],
    			['name'=>'Original Amount','sort'=>'original_amount'],
    			['name'=>'Balance Amount','sort'=>'balance_amount'],
    			['name'=>'Payment Amount','sort'=>'payment_amount'],
    			['name'=>'Payment Date','sort'=>'payment_date'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'DM No.','sort'=>'dm_number'],
    			['name'=>'DM Date','sort'=>'dm_date'],
    			['name'=>'Invoice Number','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Bank Name','sort'=>'bank_name'],
    			['name'=>'Check No.','sort'=>'cheque_number'],
    			['name'=>'Date of Check','sort'=>'cheque_date'],
    			['name'=>'Account No.','sort'=>'account_number'],
    			['name'=>'Reason','sort'=>'reason'],
    			['name'=>'Username','sort'=>'username'],
    			['name'=>'Action'],
    	];
    	
    	if($export)
    		array_pop($columns);
    	
    	return $columns;
    }
    
    
    /**
     * Get Invocie series select columns
     * @return string[][]
     */
    function getBounceCheckSelectColumns()
    {
    	return [
    			'txn_number',
    			'salesman_name',
    			'jr_salesman',
    			'area_name',
    			'customer_name',
    			'original_amount',
    			'balance_amount',
    			'payment_amount',
    			'payment_date',
    			'remarks',
    			'dm_number',
    			'dm_date',
    			'invoice_number',
    			'invoice_date',
    			'bank_name',
    			'cheque_number',
    			'cheque_date',
    			'account_number',
    			'reason',
    			'username'
    	];
    }
    
    /**
     * Get Invoice series filter  data
     * @return string[]|unknown[]
     */
    public function getBounceCheckFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area_code') ? $this->getArea()[$this->request->get('area_code')] : 'All';
    	 
    	$filters = [
    			'Salesman' => $salesman,
    			'Area' => $area
    	];
    	 
    	return $filters;
    }
    
}
