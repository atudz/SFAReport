<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Filters\SelectFilter;

class ReportsPresenter extends PresenterCore
{
    /**
     * Display main dashboard
     *
     * @return Response
     */
    public function dashboard()
    {
        $this->view->title = 'Dashboard';
        return $this->view('dashboard');
    }
	
    /**
     * Display main dashboard
     *
     * @return Response
     */
    public function index()
    {
    	return $this->view('index');
    }
    
    
    /**
     * Return sales collection view
     * @param string $type
     * @return string The rendered html view
     */
    public function salesCollection($type='report')
    {
    	switch($type)
    	{
    		case 'report':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getSalesCollectionReportColumns();
    			return $this->view('salesCollectionReport');
    		case 'posting':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getSalesCollectionPostingColumns();
    			return $this->view('salesCollectionPosting');
    		case 'summary':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->area = $this->getArea();
    			$this->view->tableHeaders = $this->getSalesCollectionSummaryColumns();
    			return $this->view('salesCollectionSummary');
    	}
    }
    
    /**
     * Return sales report view
     * @param string $type
     * @return string The rendered html view
     */
    public function salesReport($type='permaterial')
    {
    	switch($type)
    	{
    		case 'permaterial':
    			return $this->view('salesReportPerMaterial');
    		case 'perpeso':
    			return $this->view('salesReportPerPeso');
    		case 'returnpermaterial':
    			return $this->view('returnsPerMaterial');
    		case 'returnperpeso':
    			return $this->view('returnsPerPeso');
    	}
    }
    
    
    /**
     * Return van & inventory view
     * @param string $type
     * @return string The rendered html view
     */
    public function vanInventory($type='canned')
    {
    	switch($type)
    	{
    		case 'canned':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getVanInventoryColumns();
    			return $this->view('vanInventoryCanned');
    		case 'frozen':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getVanInventoryColumns();
    			return $this->view('vanInventoryFrozen');
    	}
    }
    
    /**
     * Return bir view
     * @param string $type
     * @return string The rendered html view
     */
    public function bir()
    {
    	$this->view->salesman = $this->getSalesman();
    	$this->view->area = $this->getArea();
    	$this->view->tableHeaders = $this->getBirColumns();
    	return $this->view('bir');
    }
    
    
    /**
     * Return Unpaid Invoice view
     * @param string $type
     * @return string The rendered html view
     */
    public function unpaidInvoice()
    {
    	return $this->view('unpaidInvoice');
    }
    /**
     * Return report sync view
     * @param string $type
     * @return string The rendered html view
     */
    public function sync()
    {
    	return $this->view('sync');
    }
    
    
    /**
     * Get records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecords($type)
    {
    	switch($type)
    	{
    		case 'salescollectionreport';
    			return $this->getSalesCollectionReport();
    		case 'salescollectionposting';
    			return $this->getSalesCollectionPosting();
    		case 'salescollectionsummary';
    			return $this->getSalesCollectionSummary();
    		case 'vaninventory';
    			return $this->getVanInventory();
    		case 'unpaidinvoice';
    			return $this->getUnpaidInvoice();    		
    		case 'bir';
    			return $this->getBir();
			case 'salesportpermaterial';
    			return $this->getSalesReportMaterial();
    		case 'salesportperpeso';
    			return $this->getSalesReportPeso();
    		case 'returnpermaterial';
    			return $this->getReturnMaterial();
    		case 'returnperpeso';
    			return $this->getReturntPeso();
    		case 'customerlist';
    			return $this->getCustomerList();
    		case 'salesmanlist';
    			return $this->getSalesmanList();
    		case 'materialpricelist';
    			return $this->getMaterialPriceList();
    	}
    }
    
    
    /**
     * Get Sales & Collection Report records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionReport()
    {
    	    	
    	$prepare = \DB::table('user');
    	
    	$codeFilter = FilterFactory::getInstance('Text','Company Code');
    	$prepare = $codeFilter->addFilter($prepare,'code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange','Invoice Date');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date');
    	
    	$collectionDateFilter = FilterFactory::getInstance('DateRange','Collection Date');
    	$prepare = $collectionDateFilter->addFilter($prepare,'collection_date');
    	
    	$postingDateFilter = FilterFactory::getInstance('DateRange','Posting Date');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'posting_date');
    
    	$result = $this->paginate($prepare);
    	
    	
    	return response()->json($this->dummy());
    }
    
    
    /**
     * Get Sales & Collection Posting records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionPosting()
    {
    
    	$prepare = \DB::table('user');
    	 
    	$codeFilter = FilterFactory::getInstance('Text','Company Code');
    	$prepare = $codeFilter->addFilter($prepare,'code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange','Invoice Date');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date');
    	 
    	$collectionDateFilter = FilterFactory::getInstance('DateRange','Collection Date');
    	$prepare = $collectionDateFilter->addFilter($prepare,'collection_date');
    	 
    	$postingDateFilter = FilterFactory::getInstance('DateRange','Posting Date');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'posting_date');
    
    	$result = $this->paginate($prepare);
    	 
    	 
    	return response()->json($this->dummy());
    }
    
    
    /**
     * Get Sales & Collection Posting records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionSummary()
    {
    
    	$prepare = \DB::table('user');
    
    	$codeFilter = FilterFactory::getInstance('Text','Company Code');
    	$prepare = $codeFilter->addFilter($prepare,'code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    
    	$monthDateFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $monthDateFilter->addFilter($prepare,'invoice_date');
    
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$result = $this->paginate($prepare);
    
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Van & Inventory records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVanInventory()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'area');
    	
   		$transactionFilter = FilterFactory::getInstance('DateRange','Transaction');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
   
    	$invoiceFilter = FilterFactory::getInstance('DateRange','Invoice');
    	$prepare = $invoiceFilter->addFilter($prepare,'invoice_date');
    	
    	$postingFilter = FilterFactory::getInstance('DateRange','Posting');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    	
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    
    /**
     * Get Unpaid Invoice records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnpaidInvoice()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'area');
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date');
    
    	$result = $this->paginate($prepare);
    
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Bir records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBir()
    {
    
    	$prepare = \DB::table('user');
    
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    
    	$documentFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $documentFilter->addFilter($prepare,'document_date');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Depot',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'depot');
    	
    	$assignmentFilter = FilterFactory::getInstance('Select','Assignment',SelectFilter::SINGLE_SELECT);
    	$prepare = $assignmentFilter->addFilter($prepare,'assignment');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Sales Report Per Material
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportMaterial()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    	
    	$customerFilter = FilterFactory::getInstance('Select','Customer',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerFilter->addFilter($prepare,'customer');
    	
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$itemCodeFilter = FilterFactory::getInstance('Select','Item Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code');
    	
    	$segmentCodeFilter = FilterFactory::getInstance('Select','Segement Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code');
    
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    	 
    	$postingFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    	
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Sales Report Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportPeso()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    	 
    	$customerFilter = FilterFactory::getInstance('Select','Customer',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerFilter->addFilter($prepare,'customer');
    	 
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$postingFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    	 
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Return Material
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnMaterial()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	 
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$customerFilter = FilterFactory::getInstance('Select','Customer',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerFilter->addFilter($prepare,'customer');
    
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$itemCodeFilter = FilterFactory::getInstance('Select','Item Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code');
    	 
    	$segmentCodeFilter = FilterFactory::getInstance('Select','Segement Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code');
    	
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$postingFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Return Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturntPeso()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    	 
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$customerFilter = FilterFactory::getInstance('Select','Customer',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerFilter->addFilter($prepare,'customer');
    
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$postingFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Cusomter List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerList()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Salesman List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesmanList()
    {
    
    	$prepare = \DB::table('user');
    
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman');
    
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$statusFilter = FilterFactory::getInstance('Select','Status',SelectFilter::SINGLE_SELECT);
    	$prepare = $statusCodeFilter->addFilter($prepare,'status');
    	
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    /**
     * Get Material Price List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaterialPriceList()
    {
    
    	$prepare = \DB::table('user');
    
    	$customerCodeFilter = FilterFactory::getInstance('Select','Customer Code',SelectFilter::SINGLE_SELECT);
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area');
    
    	$segmentCodeFilter = FilterFactory::getInstance('Select','Segement',SelectFilter::SINGLE_SELECT);
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code');
    	
    	$materialFilter = FilterFactory::getInstance('Select','Material',SelectFilter::SINGLE_SELECT);
    	$prepare = $materialFilter->addFilter($prepare,'material');
    
    	$statusFilter = FilterFactory::getInstance('Select','Status',SelectFilter::SINGLE_SELECT);
    	$prepare = $statusCodeFilter->addFilter($prepare,'status');
    	
    	$transactionFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
    
    	$result = $this->paginate($prepare);
    
    	return response()->json($this->dummy());
    }
    
    public function dummy()
    {    	
    /* 	return ['records' => [
    			['name'=>'Abner Tudtud','age'=>'10','money'=>'10'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud','age'=>'10','money'=>'10'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    			['name'=>'Abner Tudtud1','age'=>'11','money'=>'101'],
    	]]; */
    	$data['records'] = [
    			['a1'=>'1000_10003574',
    				 'a2' =>'1000_BARDS-Blue Ice Store',
    				 'a3' =>'',
    				 'a4' => 'CBA0011',
    				 'a5' => '08/03/2015',
    				 'a6' => '1,562.50',
    				 'a7' => '',
    				 'a8' => '31.25',
    				 'a9' => '1,531.25',
    				 'a10' => '',
    				 'a11' => '-',
    				 'a12' => 'MBA0001',
    				 'a13' => '107.8',
    				 'a14' => '(2.16)',
    				 'a15' => '105.64',
    				 'a16' => '08/03/2015',
    				 'a17' => 'CBA0011',
    				 'a18' => '423.45',
    				 'a19' => ' 1,000.00',
    				 'a20' => 'MBTC Lahug',
    				 'a21' => '133455',
    				 'a22' => '08/15/2015',
    				 'a23' => '',
    				 'a24' => '',
    				 'a25' => '',
    				 'a26' => '',
    				 'a27' => '1,423.45'
    			],
    
    			['a1'=>'1000_10003615',
    					'a2' =>'1000_BARDS-Dela Peña Store ',
    					'a3' =>'',
    					'a4' => 'CBA0012',
    					'a5' => '08/03/2015',
    					'a6' => '1,562.50',
    					'a7' => '',
    					'a8' => '31.25',
    					'a9' => '1,531.25',
    					'a10' => '',
    					'a11' => '-',
    					'a12' => 'MBA0002',
    					'a13' => '210.70',
    					'a14' => '(4.21)',
    					'a15' => '206.49',
    					'a16' => '08/03/2015',
    					'a17' => 'CBA0012',
    					'a18' => '423.45',
    					'a19' => '1000<br>320.55',
    					'a20' => 'BPI Carcar<br>BPI Pacific Mall',
    					'a21' => '133455',
    					'a22' => '08/15/2015',
    					'a23' => '',
    					'a24' => '',
    					'a25' => '',
    					'a26' => '',
    					'a27' => '1,423.45'
    			],
    
    
    			['a1'=>'Total',
    					'a2' =>'',
    					'a3' =>'',
    					'a4' => '',
    					'a5' => '',
    					'a6' => ' 3,125.00',
    					'a7' => '',
    					'a8' => '62.50',
    					'a9' => ' 3,062.50',
    					'a10' => '-',
    					'a11' => '-',
    					'a12' => '-',
    					'a13' => ' 318.50',
    					'a14' => ' (6.37)',
    					'a15' => ' 312.13',
    					'a16' => ' ',
    					'a17' => '',
    					'a18' => '-',
    					'a19' => ' 423.45',
    					'a20' => ' 2,320.55',
    					'a21' => '',
    					'a22' => '',
    					'a23' => '',
    					'a24' => '',
    					'a25' => '',
    					'a26' => '',
    					'a27' => ' 2,744.00'
    			],
    
    	];
    	return $data;
    }
    
    /**
     * Get Table Column Headers
     * @param unknown $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableColumns($type='')
    {
    	switch($type)
    	{
    		case 'salescollectionreport';
    			return $this->getSalesCollectionReportColumns();
    		case 'salescollectionposting';
    			return $this->getSalesCollectionPostingColumns();
    		case 'salescollectionsummary';
    			return $this->getSalesCollectionSummaryColumns();
    		case 'vaninventory';
    			return $this->getVanInventoryColumns();
    		case 'unpaidinvoice';
    			return $this->getVanInventoryColumns();
    		case 'bir';
    			return $this->getBirColumns();
    		case 'salesportpermaterial';
    			return $this->getSalesReportMaterial();
    		case 'salesportperpeso';
    			return $this->getSalesReportPeso();
    		case 'returnpermaterial';
    			return $this->getReturnMaterial();
    		case 'returnperpeso';
    			return $this->getReturntPeso();
    		case 'customerlist';
    			return $this->getCustomerList();
    		case 'salesmanlist';
    			return $this->getSalesmanList();
    		case 'materialpricelist';
    			return $this->getMaterialPriceList();
    	}	
    }
    
    /**
     * Get Sales Collection Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionReportColumns()
    {    
    	$headers = [
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Invoice Number','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Total Invoice Gross Amt'],
    			['name'=>'Invoice Discount Amount 1','sort'=>'so_total_item_discount'],
    			['name'=>'Invoice Discount Amount 2','sort'=>'so_total_collective_discount'],
    			['name'=>'Total Invoice Amount','sort'=>'so_total_invoice_amount'],
    			['name'=>'CM Number','sort'=>'cm_number'],
    			['name'=>'Other Deduction Amount'],
    			['name'=>'Return Slip Number','sort'=>'return_slip_num'],
    			['name'=>'Total Return Amount'],
    			['name'=>'Return Discount Amount'],
    			['name'=>'Return net amount'],
    			['name'=>'Total Invoice Net Amount'],
    			['name'=>'Collection Date','sort'=>'collection_date'],
    			['name'=>'OR Number','sort'=>'or_number'],
    			['name'=>'Cash'],
    			['name'=>'Check Amount'],
    			['name'=>'Bank Name'],
    			['name'=>'Check No'],
    			['name'=>'Check Date'],
    			['name'=>'CM No'],
    			['name'=>'CM Date'],
    			['name'=>'CM Amount'],
    			['name'=>'Total Collected Amount'],
    	];
    	
    	return $headers;
    }
    
    
    /**
     * Get Sales Collection Posting Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionPostingColumns()
    {
    	$headers = [
    			['name'=>'Activity Code','sort'=>'activity_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Invoice Number','sort'=>'invoice_number'],
    			['name'=>'Total Invoice Net Amount'],
    			['name'=>'Invoice Date'],
    			['name'=>'Invoice Posting Date'],
    			['name'=>'OR Number','sort'=>'or_number'],
    			['name'=>'OR Amount'],
    			['name'=>'OR Date'],
    			['name'=>'Collection Posting Date']
    	];
    	 
    	return $headers;
    }
    
    
    /**
     * Get Sales Collection Posting Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionSummaryColumns()
    {
    	$headers = [
    			['name'=>'SCR#','sort'=>'scr_number'],
    			['name'=>'Invoice Number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Total Collected Amount'],
    			['name'=>'12% Sales Tax'],
    			['name'=>'Amount Subject To Commission']
    	];
    
    	return $headers;
    }
    
    
    /**
     * Get Van Inventory Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVanInventoryColumns()
    {
    	$headers = [
    			['name'=>'Customer','sort'=>true],
    			['name'=>'Invoice Date','sort'=>true],
    			['name'=>'Invoice No.','sort'=>true],    			 
    			['name'=>'Return Slip No.','sort'=>true],
    			['name'=>'Transaction Date','sort'=>true],
    			['name'=>'Stock Transfer No.','sort'=>true],
    			['name'=>'Replenishment Date','sort'=>true],
    			['name'=>'Replenishment Number','sort'=>true]
    	];
    
    	return $headers;
    }
    
    /**
     * Get Bir Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBirColumns()
    {
    	$headers = [
    			['name'=>'Document Date','sort'=>true],
    			['name'=>'Name','sort'=>true],
    			['name'=>'Customer Address','sort'=>true],
    			['name'=>'Depot','sort'=>true],
    			['name'=>'Reference','sort'=>true],
    			['name'=>'Vat Registration No.','sort'=>true],
    			['name'=>'Sales-Exempt','sort'=>true],
    			['name'=>'Sales-0%','sort'=>true],
    			['name'=>'Sales-12%','sort'=>true],
    			['name'=>'Total Sales','sort'=>true],
    			['name'=>'Tax Amount','sort'=>true],
    			['name'=>'Total Invoice Amount','sort'=>true],
    			['name'=>'Local Sales','sort'=>true],
    			['name'=>'Term-Cash','sort'=>true],
    			['name'=>'Term-on-Account','sort'=>true],
    			['name'=>'Sales Group','sort'=>true],
    			['name'=>'Assignment','sort'=>true],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Salesman 
     * @return multitype:
     */
    public function getSalesman()
    {
    	return \DB::table('app_salesman')->lists('salesman_name','salesman_code');
    }
    
    
    /**
     * Get Customer Code
     * @return multitype:
     */
    public function getCustomerCode()
    {
    	return \DB::table('app_customer')->lists('customer_code','customer_id');
    }
    
	/**
     * Get Area
     * @return multitype:
     */
    public function getArea()
    {
    	return \DB::table('app_area')->lists('area_name','area_code');
    } 
}
