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
    			$this->view->customers = $this->getCustomer();
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->items = $this->getItems();
    			$this->view->segments = $this->getItemSegmentCode();
    			$this->view->tableHeaders = $this->getSalesReportMaterialColumns();    			 
    			return $this->view('salesReportPerMaterial');
    		case 'perpeso':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getSalesReportPesoColumns();
    			return $this->view('salesReportPerPeso');
    		case 'returnpermaterial':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->items = $this->getItems();
    			$this->view->segments = $this->getItemSegmentCode();
    			$this->view->tableHeaders = $this->getReturnReportMaterialColumns();
    			return $this->view('returnsPerMaterial');
    		case 'returnperpeso':
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getReturnReportMaterialColumns();    			
    			return $this->view('returnsPerPeso');
    		case 'customerlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->tableHeaders = $this->getCustomerListColumns();
    			return $this->view('customerList');
    		case 'salesmanlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->tableHeaders = $this->getSalesmanListColumns();
    			return $this->view('salesmanList');
    		case 'materialpricelist':
    			$this->view->segmentCodes = $this->getItemSegmentCode();
    			$this->view->items = $this->getItems(); 
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->tableHeaders = $this->getMaterialPriceListColumns();
    			return $this->view('materialPriceList');
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
			case 'salesreportpermaterial';
    			return $this->getSalesReportMaterial();
    		case 'salesreportperpeso';
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
    	$query = ' SELECT 
				   tas.customer_code, 
				   CONCAT(ac.customer_name,ac.customer_name2) customer_name,					
				   (select remarks from txn_evaluated_objective teo where teo.reference_num = tas.reference_num order by teo.sfa_modified_date desc limit 1) remarks,
				   sotbl.invoice_number,
				   sotbl.so_date invoice_date,
				   sotbl.so_total_served so_total_served,
				   sotbl.so_total_item_discount so_total_item_discount,					
				   sotbl.so_total_collective_discount,
				   (sotbl.so_total_served - sotbl.so_total_item_discount) total_invoice_amount,
			  	   tsohd2.ref_no other_deduction_slip_number,
				   rtntbl.return_slip_num,
				   rtntbl.RTN_total_gross,
				   rtntbl.RTN_total_collective_discount,
				   rtntbl.RTN_net_amount,
				   (sotbl.so_total_served - sotbl.so_total_item_discount - sotbl.so_total_ewt_deduction - rtntbl.rtn_net_amount) total_invoice_net_amount,	
				   coltbl.or_date,
	               coltbl.or_number,
				   IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0) cash_amount,
				   IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0) check_amount,																
				   coltbl.bank,
				   coltbl.check_number,
				   coltbl.check_date,
				   coltbl.cm_number,
				   ti.invoice_date cm_date,
			   	   IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, \'\') credit_amount,
				   (IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, \'\')) total_collected_amount

				   from txn_activity_salesman tas 
				   left join app_customer ac on ac.customer_code=tas.customer_code
				   left join				
					-- SALES ORDER SUBTABLE
					(
						select 
							all_so.so_number, 
							all_so.reference_num,  
							all_so.salesman_code, 
							all_so.customer_code,
							all_so.so_date,
							all_so.invoice_number,
							sum(all_so.total_served) as so_total_served,
							sum(all_so.total_vat) as so_total_vat,
							sum(all_so.total_discount) as so_total_item_discount,
											
							sum(tsohd.collective_discount_amount) as so_total_collective_discount,
							sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction,
											
							sum(all_so.so_amount) as so_amount,
							sum(all_so.net_amount) as so_net_amount
						from (
								select 
									tsoh.so_number, 
									tsoh.reference_num, 
									tsoh.salesman_code, 
									tsoh.customer_code,
									tsoh.so_date,
									tsoh.invoice_number,
									sum(tsod.gross_served_amount + tsod.vat_amount) as total_served,
									(sum((tsod.gross_served_amount + tsod.vat_amount)-tsod.discount_amount)/1.12)*0.12 as total_vat,
									sum(tsod.discount_amount) as total_discount,
									sum((tsod.gross_served_amount + tsod.vat_amount)-tsod.discount_amount)/1.12 as so_amount,
									sum((tsod.gross_served_amount + tsod.vat_amount)-tsod.discount_amount) as net_amount
								from txn_sales_order_header tsoh
								inner join txn_sales_order_detail tsod on tsoh.reference_num = tsod.reference_num and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
								group by tsoh.so_number, 
									tsoh.reference_num, 
									tsoh.salesman_code, 
									tsoh.van_code,
									tsoh.customer_code,
									tsoh.so_date,
									tsoh.sfa_modified_date,
									tsoh.invoice_number
					
								union all
					
								select 
									tsoh.so_number, 
									tsoh.reference_num, 
									tsoh.salesman_code, 
									tsoh.customer_code,
									tsoh.so_date,
									tsoh.invoice_number,
									sum(tsodeal.gross_served_amount + tsodeal.vat_served_amount) as total_served,
									(sum(tsodeal.gross_served_amount + tsodeal.vat_served_amount)/1.12)*0.12 as total_vat,
									0.00 as total_discount,
									sum(tsodeal.gross_served_amount + tsodeal.vat_served_amount)/1.12 as so_amount,
									sum(tsodeal.gross_served_amount + tsodeal.vat_served_amount) as net_amount
								from txn_sales_order_header tsoh
								inner join txn_sales_order_deal tsodeal on tsoh.reference_num = tsodeal.reference_num
								group by tsoh.so_number, 
									tsoh.reference_num, 
									tsoh.salesman_code, 
									tsoh.van_code, 
									tsoh.customer_code,
									tsoh.so_date,
									tsoh.sfa_modified_date,
									tsoh.invoice_number
																					
						) all_so
					
											
						left join
						(
							select 
								reference_num,
								sum(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as ewt_deduction_amount,
								sum(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_discount_amount
							from txn_sales_order_header_discount
							group by reference_num
						) tsohd on all_so.reference_num = tsohd.reference_num
					
																
						group by all_so.so_number, 
							all_so.reference_num, 
							all_so.salesman_code, 
							all_so.customer_code,
							all_so.so_date,
							all_so.invoice_number	
											
					) sotbl on sotbl.reference_num = tas.reference_num and sotbl.salesman_code = tas.salesman_code

					left join txn_sales_order_header_discount tsohd2 on sotbl.reference_num = tsohd2.reference_num and tsohd2.deduction_code=\'EWT\'
					left join 
					-- RETURN SUBTABLE
					(
						select 
							trh.return_txn_number,
							trh.reference_num, 
							trh.salesman_code, 
							trh.customer_code,
							trh.return_date, 
							trh.return_slip_num,
							sum(trd.gross_amount + trd.vat_amount) as RTN_total_gross,
							sum(trhd.collective_discount_amount) as RTN_total_collective_discount,
							sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount) 
											- sum(trhd.collective_discount_amount)
											as RTN_net_amount
						from txn_return_header trh
						inner join txn_return_detail trd on trh.reference_num = trd.reference_num and trh.salesman_code = trd.modified_by 					
						left join
						(
							select 
								reference_num, 
								sum(coalesce(deduction_amount,0)) as collective_discount_amount
							from txn_return_header_discount
							group by reference_num
						) trhd on trh.reference_num = trhd.reference_num					
						group by 
							trh.return_txn_number,
							trh.reference_num, 
							trh.salesman_code, 
							trh.customer_code,
							trh.return_date, 
							trh.sfa_modified_date, 
							trh.return_slip_num											
					) rtntbl on rtntbl.reference_num = tas.reference_num and rtntbl.salesman_code = tas.salesman_code

					-- COLLECTION SUBTABLE
					left join
					(
						select 	
							tch.reference_num,
							tch.salesman_code,
							tch.or_number,
							tch.or_amount,
							tch.or_date, 
							tcd.payment_method_code,
							tcd.payment_amount,
							tcd.check_number,
							tcd.check_date,
							tcd.bank,
							tcd.cm_number
					
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums				
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
					) coltbl on coltbl.reference_num = tas.reference_num and coltbl.salesman_code = tas.salesman_code
					
					left join txn_invoice ti on coltbl.cm_number=ti.invoice_number and ti.document_type=\'CM\'
					
					WHERE tas.activity_code like \'%SO%\'	
					ORDER BY tas.reference_num ASC, 
					 		 tas.salesman_code ASC, 
							 tas.customer_code ASC		
    			';    	
    	
    	$data = \DB::select($query);
    	return response()->json(['records'=>$data]);
    	//dd($prepare);
    	
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
    	dd($prepare);
    	$result = $this->paginate($prepare);
    	
    	
    	return response()->json($this->dummy());
    }
    
    
    /**
     * Get Sales & Collection Posting records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionPosting()
    {
    	$query = ' 
    			select 
	tas.activity_code,
	aps.salesman_name,
	tas.customer_code, 
	CONCAT(ac.customer_name,ac.customer_name2) customer_name,					
	(select remarks from txn_evaluated_objective teo where teo.reference_num = tas.reference_num order by teo.sfa_modified_date desc limit 1) remarks,
	sotbl.invoice_number,
	(sotbl.so_total_served - sotbl.so_total_item_discount - sotbl.so_total_ewt_deduction - rtntbl.rtn_net_amount) total_invoice_net_amount,	
	sotbl.so_date invoice_date,
	sotbl.sfa_modified_date invoice_posting_date,
	coltbl.or_number,
	coltbl.or_amount,
	coltbl.check_date,
	coltbl.sfa_modified_date collection_posting_date
	
from txn_activity_salesman tas 
left join app_salesman aps on aps.salesman_code = tas.salesman_code
left join app_customer ac on ac.customer_code = tas.customer_code
left join				
-- SALES ORDER SUBTABLE
(
	select 
		all_so.reference_num,  
		all_so.salesman_code, 
		all_so.customer_code,
		all_so.so_date,
		all_so.invoice_number,
		all_so.sfa_modified_date,
		sum(all_so.total_served) as so_total_served,
		sum(all_so.total_discount) as so_total_item_discount,
		sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction
	from (
			select 
				tsoh.so_number, 
				tsoh.reference_num, 
				tsoh.salesman_code, 
				tsoh.customer_code,
				tsoh.so_date,
				tsoh.sfa_modified_date,
				tsoh.invoice_number,
				sum(tsod.gross_served_amount + tsod.vat_amount) as total_served,
				sum(tsod.discount_amount) as total_discount
			from txn_sales_order_header tsoh
			inner join txn_sales_order_detail tsod on tsoh.reference_num = tsod.reference_num and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
			group by tsoh.so_number, 
				tsoh.reference_num, 
				tsoh.salesman_code, 
				tsoh.customer_code,
				tsoh.so_date,
				tsoh.sfa_modified_date,
				tsoh.invoice_number

			union all

			select 
				tsoh.so_number, 
				tsoh.reference_num, 
				tsoh.salesman_code, 
				tsoh.customer_code,
				tsoh.so_date,
				tsoh.sfa_modified_date,
				tsoh.invoice_number,
				sum(tsodeal.gross_served_amount + tsodeal.vat_served_amount) as total_served,
				0.00 as total_discount
			from txn_sales_order_header tsoh
			inner join txn_sales_order_deal tsodeal on tsoh.reference_num = tsodeal.reference_num
			group by tsoh.so_number, 
				tsoh.reference_num, 
				tsoh.salesman_code, 
				tsoh.customer_code,
				tsoh.so_date,
				tsoh.sfa_modified_date,
				tsoh.invoice_number
																
	) all_so

						
	left join
	(
		select 
			reference_num,
			sum(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as ewt_deduction_amount			
		from txn_sales_order_header_discount
		group by reference_num
	) tsohd on all_so.reference_num = tsohd.reference_num

											
	group by all_so.so_number, 
		all_so.reference_num, 
		all_so.salesman_code, 
		all_so.customer_code,
		all_so.so_date,
		all_so.invoice_number	
						
) sotbl on sotbl.reference_num = tas.reference_num and sotbl.salesman_code = tas.salesman_code

left join 
-- RETURN SUBTABLE
(
	select 
		trh.reference_num, 
		trh.salesman_code, 
		trh.customer_code,
		sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount) 
						- sum(trhd.collective_discount_amount)
						as rtn_net_amount
	from txn_return_header trh
	inner join txn_return_detail trd on trh.reference_num = trd.reference_num and trh.salesman_code = trd.modified_by 					
	left join
	(
		select 
			reference_num, 
			sum(coalesce(deduction_amount,0)) as collective_discount_amount
		from txn_return_header_discount
		group by reference_num
	) trhd on trh.reference_num = trhd.reference_num					
	group by 
		trh.return_txn_number,
		trh.reference_num, 
		trh.salesman_code, 
		trh.customer_code									
) rtntbl on rtntbl.reference_num = tas.reference_num and rtntbl.salesman_code = tas.salesman_code

-- COLLECTION SUBTABLE
left join
(
	select 	
		tch.reference_num,
		tch.salesman_code,
		tch.or_number,
		tch.or_amount,
		tch.sfa_modified_date,
		tcd.check_date
	from txn_collection_header tch
	inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums				
	left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
) coltbl on coltbl.reference_num = tas.reference_num and coltbl.salesman_code = tas.salesman_code

WHERE tas.activity_code like \'%SO%\'	
ORDER BY tas.reference_num ASC, 
 		 tas.salesman_code ASC, 
		 tas.customer_code ASC		
    			
    			';
    	 
    	$data = \DB::select($query);
    	return response()->json(['records'=>$data]);
    	
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

    	$select = 'app_customer.customer_name,
				   txn_sales_order_header.so_date invoice_date,
				   txn_sales_order_header.invoice_number,
				   txn_return_header.return_slip_num,
				   txn_replenishment_header.replenishment_date,
				   txn_replenishment_header.reference_number replenishment_number';
    	
    	$prepare = \DB::table('txn_sales_order_header')
    				->selectRaw($select)
    				->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')
    				->leftJoin('txn_return_header', function ($join){
    					$join->on('txn_sales_order_header.reference_num','=','txn_return_header.reference_num')
    						 ->where('txn_sales_order_header.salesman_code','=','txn_return_header.salesman_code');
    				})
    				->leftJoin('txn_replenishment_header','txn_sales_order_header.reference_num','=','txn_replenishment_header.reference_number');
    				//->orderBy('reference_num');
    				//->orderBy('salesman_code')
    				//->orderBy('customer_code');
		
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'area');
    	
   		$transactionFilter = FilterFactory::getInstance('DateRange','Transaction');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date');
   
    	$invoiceFilter = FilterFactory::getInstance('DateRange','Invoice');
    	$prepare = $invoiceFilter->addFilter($prepare,'invoice_date');
    	
    	$postingFilter = FilterFactory::getInstance('DateRange','Posting');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date');
    	
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    	return response()->json($data);
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
    
    	$select = 'txn_sales_order_header.so_number,
			  	   txn_sales_order_header.reference_num,
				   txn_activity_salesman.activity_code,
				   txn_sales_order_header.customer_code,
				   app_customer.customer_name,
				   (select remarks from txn_evaluated_objective where txn_evaluated_objective.reference_num = txn_sales_order_header.reference_num order by txn_evaluated_objective.sfa_modified_date desc limit 1) remarks,
				   txn_sales_order_header.van_code,
				   txn_sales_order_header.device_code,
				   txn_sales_order_header.salesman_code,
				   app_salesman.salesman_name,
				   app_area.area_name area,
				   txn_sales_order_header.invoice_number,
				   txn_sales_order_header.so_date invoice_date,
				   txn_sales_order_header.sfa_modified_date invoice_posting_date,
				   app_item_master.segment_code,
				   app_item_master.item_code,
				   app_item_master.description,
				   txn_return_detail.quantity,
				   txn_return_detail.condition_code,
				   txn_return_detail.uom_code,
				   txn_sales_order_detail.gross_served_amount,
				   txn_sales_order_detail.vat_amount,
				   txn_sales_order_detail.discount_rate,
				   txn_sales_order_detail.discount_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_discount_rate,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_discount_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.ref_no,\'\') discount_reference_num,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.remarks,\'\') discount_remarks,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_deduction_rate,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_deduction_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.ref_no,\'\') deduction_reference_num,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.remarks,\'\') deduction_remarks,
				   ((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount+IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\')+IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\'))) total_invoice
    				
    			   	
    			';
    	
    	$prepare = \DB::table('txn_sales_order_header')
    				->selectRaw($select)
    				->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')
    				->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
    				->leftJoin('app_salesman','txn_sales_order_header.salesman_code','=','app_salesman.salesman_code')
    				->leftJoin('txn_activity_salesman', function($join){
    					$join->on('txn_sales_order_header.reference_num','=','txn_activity_salesman.reference_num');
    					$join->on('txn_sales_order_header.salesman_code','=','txn_activity_salesman.salesman_code');	
    				})
    				->leftJoin('txn_return_detail','txn_sales_order_header.reference_num','=','txn_return_detail.reference_num')
    				->leftJoin('app_item_master','txn_return_detail.item_code','=','app_item_master.item_code')
    				->leftJoin('txn_sales_order_header_discount','txn_sales_order_header.reference_num','=','txn_sales_order_header_discount.reference_num')
    				->leftJoin('txn_sales_order_detail','txn_sales_order_header.reference_num','=','txn_sales_order_detail.reference_num');
    
		$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());
    				});
    	
    	$customerCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerCodeFilter->addFilter($prepare,'customer_code');
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer',
    					function($self, $model){
    						return $model->where('txn_sales_order_header.customer_code','=',$self->getValue());
    					});
    	
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    					 function($self, $model){
    						return $model->where('app_item_master.item_code','=',$self->getValue());	 	
    				});
    	
    	$segmentCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code',
    					function($self, $model){
    						return $model->where('app_item_master.segment_code','=',$self->getValue());
    				});
    
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',	
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.so_date',$self->getValue());
    				});
    	 
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.sfa_modified_date',$self->getValue());
    			});
    	
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    	return response()->json($data);
    }
    
    /**
     * Get Sales Report Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportPeso()
    {
    	$select = 'txn_sales_order_header.so_number,
			  	   txn_sales_order_header.reference_num,
				   txn_activity_salesman.activity_code,
				   txn_sales_order_header.customer_code,
				   app_customer.customer_name,
				   (select remarks from txn_evaluated_objective where txn_evaluated_objective.reference_num = txn_sales_order_header.reference_num order by txn_evaluated_objective.sfa_modified_date desc limit 1) remarks,
				   txn_sales_order_header.van_code,
				   txn_sales_order_header.device_code,
				   txn_sales_order_header.salesman_code,
				   app_salesman.salesman_name,
				   app_area.area_name area,
				   txn_sales_order_header.invoice_number,
				   txn_sales_order_header.so_date invoice_date,
				   txn_sales_order_header.sfa_modified_date invoice_posting_date,
				   txn_sales_order_detail.gross_served_amount,
				   txn_sales_order_detail.vat_amount,
				   txn_sales_order_detail.discount_rate,
				   txn_sales_order_detail.discount_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_discount_rate,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_discount_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.ref_no,\'\') discount_reference_num,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.remarks,\'\') discount_remarks,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_deduction_rate,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_deduction_amount,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.ref_no,\'\') deduction_reference_num,
				   IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.remarks,\'\') deduction_remarks,
				   ((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount+IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\')+IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\'))) total_invoice';
    	 
    	$prepare = \DB::table('txn_sales_order_header')
				    	->selectRaw($select)
				    	->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')
				    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
				    	->leftJoin('app_salesman','txn_sales_order_header.salesman_code','=','app_salesman.salesman_code')
				    	->leftJoin('txn_activity_salesman', function($join){
				    		$join->on('txn_sales_order_header.reference_num','=','txn_activity_salesman.reference_num');
				    		$join->on('txn_sales_order_header.salesman_code','=','txn_activity_salesman.salesman_code');
				    	})
				    	->leftJoin('txn_sales_order_header_discount','txn_sales_order_header.reference_num','=','txn_sales_order_header_discount.reference_num')
				    	->leftJoin('txn_sales_order_detail','txn_sales_order_header.reference_num','=','txn_sales_order_detail.reference_num');
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('app_area.area_code','=',$self->getValue());
    			});
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code');
    	 
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('app_item_master.item_code','=',$self->getValue());
    			});
    	 
    	$segmentCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code',
    			function($self, $model){
    				return $model->where('app_item_master.segment_code','=',$self->getValue());
    			});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){
    				return $model->whereBetween('txn_sales_order_header.so_date',$self->getValue());
    			});
    	
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween('txn_sales_order_header.sfa_modified_date',$self->getValue());
    			});
    	 
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    	
    	return response()->json($data);
    }
    
    /**
     * Get Return Material
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnMaterial()
    {
    
    	$select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
				(select remarks from txn_evaluated_objective teo where reference_num = txn_return_header.reference_num order by teo.sfa_modified_date desc limit 1) AS remarks,
			    txn_return_header.van_code,
			    txn_return_header.device_code,
				txn_return_header.salesman_code,
				app_salesman.salesman_name,
				app_area.area_name area,
				txn_return_header.return_slip_num,
				txn_return_header.return_date,
				txn_return_header.sfa_modified_date return_posting_date,
				app_item_master.segment_code,
				app_item_master.item_code,
				app_item_master.description,
				txn_return_detail.condition_code,
				txn_return_detail.quantity,
				txn_return_detail.uom_code,
				txn_sales_order_detail.gross_served_amount,
				txn_return_detail.vat_amount,
				txn_sales_order_detail.discount_rate,
				txn_sales_order_detail.discount_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_discount_rate,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_discount_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.ref_no,\'\') discount_reference_num,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.remarks,\'\') discount_remarks,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_deduction_rate,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_deduction_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.ref_no,\'\') deduction_reference_num,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.remarks,\'\') deduction_remarks,
				((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount+IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\')+IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\'))) total_invoice
    			';
    	
    	$prepare = \DB::table('txn_return_header')
    				->selectRaw($select)
    				->leftJoin('app_customer','txn_return_header.customer_code','=','app_customer.customer_code')
    				->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
    				->leftJoin('app_salesman','txn_return_header.salesman_code','=','app_salesman.salesman_code')
    				->leftJoin('txn_activity_salesman', function($join){
    					$join->on('txn_return_header.reference_num','=','txn_activity_salesman.reference_num');
    					$join->on('txn_return_header.salesman_code','=','txn_activity_salesman.salesman_code');	
    				})
    				->leftJoin('txn_return_detail','txn_return_header.reference_num','=','txn_return_detail.reference_num')
    				->leftJoin('app_item_master','txn_return_detail.item_code','=','app_item_master.item_code')
    				->leftJoin('txn_sales_order_header_discount','txn_return_header.reference_num','=','txn_sales_order_header_discount.reference_num')
    				->leftJoin('txn_sales_order_detail','txn_return_header.reference_num','=','txn_sales_order_detail.reference_num');
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());
    				});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code');
    	
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    					 function($self, $model){
    						return $model->where('app_item_master.item_code','=',$self->getValue());	 	
    				});
    	
    	$segmentCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code',
    					function($self, $model){
    						return $model->where('app_item_master.segment_code','=',$self->getValue());
    				});
    
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',	
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.so_date',$self->getValue());
    				});
    	 
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.sfa_modified_date',$self->getValue());
    			});
    	
    	
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    }
    
    /**
     * Get Return Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturntPeso()
    {
    
    	$select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
				(select remarks from txn_evaluated_objective teo where reference_num = txn_return_header.reference_num order by teo.sfa_modified_date desc limit 1) AS remarks,
			    txn_return_header.van_code,
			    txn_return_header.device_code,
				txn_return_header.salesman_code,
				app_salesman.salesman_name,
				app_area.area_name area,
				txn_return_header.return_slip_num,
				txn_return_header.return_date,
				txn_return_header.sfa_modified_date return_posting_date,
				app_item_master.segment_code,
				app_item_master.item_code,
				app_item_master.description,
				txn_return_detail.condition_code,
				txn_return_detail.quantity,
				txn_return_detail.uom_code,
				txn_sales_order_detail.gross_served_amount,
				txn_return_detail.vat_amount,
				txn_sales_order_detail.discount_rate,
				txn_sales_order_detail.discount_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_discount_rate,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_discount_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.ref_no,\'\') discount_reference_num,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.remarks,\'\') discount_remarks,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_rate,\'\') collective_deduction_rate,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\') collective_deduction_amount,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.ref_no,\'\') deduction_reference_num,
				IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.remarks,\'\') deduction_remarks,
				((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount+IF(txn_sales_order_header_discount.deduction_type_code=\'DISCOUNT\',txn_sales_order_header_discount.order_deduction_amount,\'\')+IF(txn_sales_order_header_discount.deduction_type_code=\'DEDUCTION\',txn_sales_order_header_discount.order_deduction_amount,\'\'))) total_invoice
    			';
    	
    	$prepare = \DB::table('txn_return_header')
    				->selectRaw($select)
    				->leftJoin('app_customer','txn_return_header.customer_code','=','app_customer.customer_code')
    				->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
    				->leftJoin('app_salesman','txn_return_header.salesman_code','=','app_salesman.salesman_code')
    				->leftJoin('txn_activity_salesman', function($join){
    					$join->on('txn_return_header.reference_num','=','txn_activity_salesman.reference_num');
    					$join->on('txn_return_header.salesman_code','=','txn_activity_salesman.salesman_code');	
    				})
    				->leftJoin('txn_return_detail','txn_return_header.reference_num','=','txn_return_detail.reference_num')
    				->leftJoin('app_item_master','txn_return_detail.item_code','=','app_item_master.item_code')
    				->leftJoin('txn_sales_order_header_discount','txn_return_header.reference_num','=','txn_sales_order_header_discount.reference_num')
    				->leftJoin('txn_sales_order_detail','txn_return_header.reference_num','=','txn_sales_order_detail.reference_num');
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());
    				});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code');
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',	
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.so_date',$self->getValue());
    				});
    	 
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    					function($self, $model){
    						return $model->whereBetween('txn_sales_order_header.sfa_modified_date',$self->getValue());
    			});
    	
    	
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    }
    
    /**
     * Get Cusomter List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerList()
    {
    
    	$select = '
    			app_customer.customer_code,
				app_customer.customer_name,
				app_customer.address_1 address,
				app_customer.area_code,
				app_area.area_name,
				app_customer.storetype_code,
				app_storetype.storetype_name,
				app_customer.vatposting_code,
				app_customer.vat_ex_flag,
				app_customer.customer_price_group,
				app_salesman.salesman_code,
				app_salesman.salesman_name,
				app_salesman_van.van_code,
				app_customer.sfa_modified_date,
				IF(app_customer.status=\'A\',\'Active\',IF(app_customer.status=\'I\',\'Inactive\',\'Deleted\')) status
    			';
    	
    	$prepare = \DB::table('app_customer')
    				->selectRaw($select)
    				->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
    				->leftJoin('app_storetype','app_customer.storetype_code','=','app_storetype.storetype_code')
    				->leftJoin('app_salesman_customer','app_customer.customer_code','=','app_salesman_customer.customer_code')
    				->leftJoin('app_salesman','app_salesman_customer.salesman_code','=','app_salesman.salesman_code')
    				->leftJoin('app_salesman_van','app_salesman.salesman_code','=','app_salesman_van.salesman_code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code',
    					function($self,$model){
    						return $model->where('app_salesman.salesman_code','=',$self->getValue());    		
    				});
    	    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());
    				});
    	
    	$statusFilter = FilterFactory::getInstance('Select');
    	$prepare = $statusFilter->addFilter($prepare,'status');
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code');
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	 
    	
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    	
    }
    
    /**
     * Get Salesman List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesmanList()
    {
    
    	$select = '
    			app_salesman.salesman_code,
    			app_salesman.salesman_name,
    			app_customer.area_code,
				app_area.area_name,
    			app_salesman_van.van_code,
    			app_salesman.sfa_modified_date,
				IF(app_salesman.status=\'A\',\'Active\',IF(app_salesman.status=\'I\',\'Inactive\',\'Deleted\')) status
    			';
    	
    	$prepare = \DB::table('app_salesman')
    				->selectRaw($select)
    				->leftJoin('app_salesman_customer','app_salesman.salesman_code','=','app_salesman_customer.salesman_code')
    				->leftJoin('app_customer','app_salesman_customer.customer_code','=','app_customer.customer_code')
    				->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
    				->leftJoin('app_salesman_van','app_salesman.salesman_code','=','app_salesman_van.salesman_code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());
    				});
    	
    	$statusFilter = FilterFactory::getInstance('Select');
    	$prepare = $statusFilter->addFilter($prepare,'status');
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code', 
    					function($self, $model){
    						return $model->where('app_customer.customer_code','=',$self->getValue());
    				});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	 
    	
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    	
    }
    
    /**
     * Get Material Price List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaterialPriceList()
    {
    
    	$select = '
    			app_item_master.item_code,
    			app_item_master.description,
    			app_item_master_uom.uom_code,
				app_item_master.segment_code,
    			app_item_price.unit_price,
    			app_item_price.customer_price_group,
    			app_item_price.effective_date_from,
    			app_item_price.effective_date_to,
    			app_area.area_name,
    			app_item_master.sfa_modified_date,
				IF(app_item_master.status=\'A\',\'Active\',IF(app_item_master.status=\'I\',\'Inactive\',\'Deleted\')) status
    			';
    	 
    	$prepare = \DB::table('app_item_master')
    					->selectRaw($select)
				    	->leftJoin('app_item_master_uom','app_item_master.item_code','=','app_item_master_uom.item_code')
				    	->leftJoin('app_item_price','app_item_master.item_code','=','app_item_price.item_code')
				    	->leftJoin('app_customer','app_item_price.customer_price_group','=','app_customer.customer_price_group')
				    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code');
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('app_area.area_code','=',$self->getValue());
    			});
    	 
    	$statusFilter = FilterFactory::getInstance('Select');
    	$prepare = $statusFilter->addFilter($prepare,'status');
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code',
    			function($self, $model){
    				return $model->where('app_customer.customer_code','=',$self->getValue());
    			});
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    
    	 
    	//dd($prepare->toSql());
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    	 
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
    		case 'salesreportpermaterial';
    			return $this->getSalesReportMaterialColumns();
    		case 'salesreportperpeso';
    			return $this->getSalesReportPeso();
    		case 'returnpermaterial';
    			return $this->getReturnMaterial();
    		case 'returnperpeso';
    			return $this->getReturntPeso();
    		case 'customerlist';
    			return $this->getCustomerListColumns();
    		case 'salesmanlist';
    			return $this->getSalesmanListColumns();
    		case 'materialpricelist';
    			return $this->getMaterialPriceListColumns();
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
    			//['name'=>'Transaction Date','sort'=>true],
    			//['name'=>'Stock Transfer No.','sort'=>true],
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
     * Get Sales Report Material Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportMaterialColumns()
    {
    	$headers = [
    			['name'=>'SO number'],
    			['name'=>'Reference number'],
    			['name'=>'Activity Code','sort'=>'activity_code'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Invoice No/ Return Slip No.','sort'=>'return_slip_number'],
    			['name'=>'Invoice Date/ Return Date','sort'=>'invoice_date'],
    			['name'=>'Invoice/Return Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Segment Code','sort'=>'segment_code'],
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Quantity','sort'=>'quantity'],
    			['name'=>'Condition Code','sort'=>'condition_code'],
    			['name'=>'Uom Code'],
    			['name'=>'Gross Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Collective Deduction Rate'],
    			['name'=>'Collective Deduction Amount'],
    			['name'=>'Reference No.','sort'=>'deduction_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Invoice/Return Net amount'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Sales Report Material Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportPesoColumns()
    {
    	$headers = [
    			['name'=>'SO number'],
    			['name'=>'Reference number'],
    			['name'=>'Activity Code','sort'=>'activity_code'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Invoice No/ Return Slip No.','sort'=>'return_slip_number'],
    			['name'=>'Invoice Date/ Return Date','sort'=>'invoice_date'],
    			['name'=>'Invoice/Return Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Gross Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Collective Deduction Rate'],
    			['name'=>'Collective Deduction Amount'],
    			['name'=>'Reference No.','sort'=>'deduction_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Invoice/Return Net amount'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Return Report Material Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnReportMaterialColumns()
    {
    	$headers = [
    			['name'=>'Return Transaction Number'],
    			['name'=>'Reference number'],
    			['name'=>'Activity Code','sort'=>'activity_code'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Return Slip No.','sort'=>'return_slip_number'],
    			['name'=>'Return Date','sort'=>'invoice_date'],
    			['name'=>'Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Segment Code','sort'=>'segment_code'],
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Quantity','sort'=>'quantity'],
    			['name'=>'Condition Code','sort'=>'condition_code'],
    			['name'=>'Uom Code'],
    			['name'=>'Gross Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate','sort'=>'collective_discount_rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Invoice/Return Net amount'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Return Report Per Peso Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnReportPerPesoColumns()
    {
    	$headers = [
    			['name'=>'Return Transaction Number'],
    			['name'=>'Reference number'],
    			['name'=>'Activity Code','sort'=>'activity_code'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Return Slip No.','sort'=>'return_slip_number'],
    			['name'=>'Return Date','sort'=>'invoice_date'],
    			['name'=>'Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Gross Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate','sort'=>'collective_discount_rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Invoice/Return Net amount'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Customer List Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerListColumns()
    {
    	$headers = [
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Address','sort'=>'address'],
    			['name'=>'Area Code','sort'=>'area_code'],
    			['name'=>'Area Name','sort'=>'area_name'],
    			['name'=>'Storetype Code','sort'=>'storetype_code'],
    			['name'=>'Storetype Name','sort'=>'storetype_name'],
    			['name'=>'Vatposting Code','sort'=>'vatposting_code'],
    			['name'=>'Vat ex flag','sort'=>'vat_ex_flag'],
    			['name'=>'Customer Price Group','sort'=>'customer_price_group'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'SFA Modified Date','sort'=>'sfa_modified_date'],
    			['name'=>'Status','sort'=>'status'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Customer List Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesmanListColumns()
    {
    	$headers = [
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area Code','sort'=>'area_code'],
    			['name'=>'Area Name','sort'=>'area_name'],    			 
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'SFA Modified Date','sort'=>'sfa_modified_date'],
    			['name'=>'Status','sort'=>'status'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Customer List Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaterialPriceListColumns()
    {
    	$headers = [
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Uom Code','sort'=>'uom_code'],
    			['name'=>'Segment Code','sort'=>'segment_code'],
    			['name'=>'Unit Price','sort'=>'unit_price'],
    			['name'=>'Customer Price Group','sort'=>'custom_price_group'],
    			['name'=>'Effective date from','sort'=>'effective_date_from'],
    			['name'=>'Effective date to','sort'=>'effective_date_to'],
    			['name'=>'Area','sort'=>'area_name'],
    			['name'=>'SFA Modified Date','sort'=>'sfa_modified_date'],
    			['name'=>'Status','sort'=>'status'],
    	];
    
    	return $headers;
    }
    
    /**
     * Get Salesman 
     * @return multitype:
     */
    public function getSalesman()
    {
    	return \DB::table('app_salesman')
    				->orderBy('salesman_name')
    				->lists('salesman_name','salesman_code');
    }
    
    
    /**
     * Get Customers
     * @return multitype:
     */
    public function getCustomer()
    {
    	return \DB::table('app_customer')
    	->orderBy('customer_name')
    	->lists('customer_name','customer_code');
    }
    
    /**
     * Get Customer Code
     * @return multitype:
     */
    public function getCustomerCode()
    {
    	return \DB::table('app_customer')
    				->orderBy('customer_code')
    				->lists('customer_code','customer_id');
    }
    
	/**
     * Get Area
     * @return multitype:
     */
    public function getArea()
    {
    	return \DB::table('app_area')
    			->orderBy('area_name')
    			->lists('area_name','area_code');
    }

    /**
     * Get Item Lists
     */
    public function getItems()
    {
    	return \DB::table('app_item_master')
    			->orderBy('description')
    			->lists('description','item_code');
    }
    
    /**
     * Get Item Segment Codes
     */
    public function getItemSegmentCode()
    {
    	return \DB::table('app_item_segment')
    			->orderBy('segment_code')
    			->lists('segment_code','item_segment_id');
    }
    
    /**
     * Get Customer Statuses
     */
    public function getCustomerStatus()
    {    	
    	$statusList = ['A'=>'Active','D'=>'Deleted','I'=>'Inactive',];    	
    	return $statusList;
    }
}
