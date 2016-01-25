<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Filters\SelectFilter;
use Illuminate\Database\Query\Builder;
use App\Factories\PresenterFactory;
use Carbon\Carbon;
use App\Factories\LibraryFactory;

class ReportsPresenter extends PresenterCore
{
	/**
	 * Valid excel export types
	 * @var unknown
	 */
	
	protected $validExportTypes = ['xls','xlsx','pdf']; 
	
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
    	/* $unpaid = $this->getDataCount('unpaidinvoice')->getData();
    	$this->view->unpaidTotal = $unpaid->total;
    	
    	$sales = $this->getDataCount('salesreportpermaterial')->getData();
    	$this->view->salesTotal = $sales->total;
    	
    	$van = $this->getDataCount('vaninventoryfrozen')->getData();
    	$this->view->vanTotal = $van->total;
    	 */
    	
    	$this->view->unpaidTotal = 0;
    	$this->view->salesTotal = 0;
    	$this->view->vanTotal = 0;
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
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->items = $this->getItems();
    			$this->view->segments = $this->getItemSegmentCode();
    			$this->view->tableHeaders = $this->getSalesReportMaterialColumns();    			 
    			return $this->view('salesReportPerMaterial');
    		case 'perpeso':
    			$this->view->companyCode = $this->getCompanyCode();    			
    			$this->view->salesman = $this->getSalesman();
    			$this->view->customers = $this->getCustomer();    			 
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getSalesReportPesoColumns();
    			return $this->view('salesReportPerPeso');
    		case 'returnpermaterial':
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->items = $this->getItems();
    			$this->view->segments = $this->getItemSegmentCode();
    			$this->view->tableHeaders = $this->getReturnReportMaterialColumns();
    			return $this->view('returnsPerMaterial');
    		case 'returnperpeso':
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getReturnReportPerPesoColumns();    			
    			return $this->view('returnsPerPeso');
    		case 'customerlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->tableHeaders = $this->getCustomerListColumns();
    			return $this->view('customerList');
    		case 'salesmanlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->tableHeaders = $this->getSalesmanListColumns();
    			return $this->view('salesmanList');
    		case 'materialpricelist':
    			$this->view->segmentCodes = $this->getItemSegmentCode();
    			$this->view->items = $this->getItems(); 
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
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
    			$this->view->title = 'Canned & Mixes';
    			$this->view->salesman = $this->getSalesman(true);
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->tableHeaders = $this->getVanInventoryColumns();
    			$this->view->itemCodes = $this->getVanInventoryItems('canned','item_code');
    			$this->view->type = 'canned';
    			return $this->view('vanInventory');
    		case 'frozen':
    			$this->view->title = 'Frozen & Kassel';
    			$this->view->salesman = $this->getSalesman(true);
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->tableHeaders = $this->getVanInventoryColumns('frozen');
    			$this->view->itemCodes = $this->getVanInventoryItems('frozen','item_code');
    			$this->view->type = 'frozen';
    			return $this->view('vanInventory');
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
    	$this->view->salesman = $this->getSalesman();
    	$this->view->customers = $this->getCustomer();
    	$this->view->companyCode = $this->getCompanyCode();
    	$this->view->tableHeaders = $this->getUnpaidColumns();
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
    		case 'salescollectionreport':
    			return $this->getSalesCollectionReport();
    		case 'salescollectionposting':
    			return $this->getSalesCollectionPosting();
    		case 'salescollectionsummary':
    			return $this->getSalesCollectionSummary();
    		case 'vaninventoryfrozen':    			
    		case 'vaninventorycanned':
    			return $this->getVanInventory();
    		case 'unpaidinvoice':
    			return $this->getUnpaidInvoice();    		
    		case 'bir':
    			return $this->getBir();
			case 'salesreportpermaterial':
    			return $this->getSalesReportMaterial();
    		case 'salesreportperpeso':
    			return $this->getSalesReportPeso();
    		case 'returnpermaterial':
    			return $this->getReturnMaterial();
    		case 'returnperpeso':
    			return $this->getReturnPeso();
    		case 'customerlist':
    			return $this->getCustomerList();
    		case 'salesmanlist':
    			return $this->getSalesmanList();
    		case 'materialpricelist';
    			return $this->getMaterialPriceList();    			
    		case 'conditioncodes':
    			return $this->getConditionCodes();
    		case 'userlist':
    			return PresenterFactory::getInstance('User')->getUsers();	
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
    	//dd($prepare);
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
     * Get van inventory stock items
     * @param unknown $transferId
     * @param unknown $itemCodes
     * @return unknown
     */
    public function getVanInventoryStockItems($transferId, $itemCodes)
    {
    	$stockItems = \DB::table('txn_stock_transfer_in_detail')
					    	->select(['item_code','quantity'])
					    	->whereIn('item_code',$itemCodes)
					    	->where('stock_transfer_number','=',$transferId)
					    	->get();
    	return $stockItems;
    }

    /**
     * Get Van & Inventory records
     * @param string $reports
     * @param number $offset
     * @return multitype:array NULL
     */
    public function getVanInventory($reports=false,$offset=0)
    {
    	// This is a required field so return empty if there's none
    	if(!$this->request->get('transaction_date'))
    	{
    		$data = [
    			'records' => [],
    			'replenishment' => [],
    			'short_over_stocks' => [],
    			'stock_on_hand' => [],
    			'stocks' => [],
    			'toal' => 0	
    		];
    		
    		return response()->json($data);
    	} 
    	
    	$reportRecords = [];    	
    	$codes = [];
    	$itemCodes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code');    	 
    	foreach($itemCodes as $item)
    	{
    		$codes[] = $item->item_code;
    	}
    	
    	// Beginning Balance / Actual Count
    	// Get Replenishment data 
    	$prepare = \DB::table('txn_replenishment_header')
    					->select(['replenishment_date','reference_number']);
    	
    	$transactionFilter = FilterFactory::getInstance('Date');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
    			function($self, $model){
    				return $model->where(\DB::raw('DATE(txn_replenishment_header.replenishment_date)'),'=',$self->getValue());
    			});
    	
    	$referenceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceNumFilter->addFilter($prepare,'reference_number');
    	
    	$replenishment = $prepare->first();
    			 
    	$replenishmentItems = [];
    	$tempActualCount = [];
    	if($replenishment)
    	{
    		$replenishmentItems = \DB::table('txn_replenishment_detail')
				    				->select(['item_code','quantity'])
				    				->whereIn('item_code',$codes)
				    				->where('reference_number','=',$replenishment->reference_number)
				    				->get();
    		foreach($replenishmentItems as $item)
    		{
    			$replenishment->{'code_'.$item->item_code} = $item->quantity;
    			$tempActualCount['code_'.$item->item_code] = $item->quantity;
    		}    			    			
    		
    		$replenishment->total = 1;    		
    	}
    	else
    	{
    		$replenishment['total'] = 0;
    	}
    			 
    	$data['replenishment'] = (array)$replenishment;
    	//$reportRecords[] = array_merge(['customer_name'=>'<strong>Beginning Balance</strong>'],(array)$replenishment);
    	if($replenishment && isset($replenishment->total) && $replenishment->total)
    		$reportRecords[] = array_merge(['customer_name'=>'<strong>Actual Count</strong>'],(array)$replenishment);
    			
    	
    	// Get Van Inventory stock transfer data
    	$prepare = $this->getPreparedVanInventoryStocks();
    	$stocks = $prepare->first();    	
    	
    	$stockItems = [];
    	$tempStockTransfer = [];
    	if($stocks) 
    	{
	    	$stockItems = $this->getVanInventoryStockItems($stocks->stock_transfer_number, $codes);
	    	foreach($stockItems as $item)
	    	{
	    		$stocks->{'code_'.$item->item_code} = $item->quantity;
	    		$tempStockTransfer['code_'.$item->item_code] = $item->quantity;
	    	}
    	}
    	else
    	{
    		// pull previous stock transfer
    		$tempStockTransfer = $this->getPreviousStockOnHand($this->request->get('transaction_date'));
    	}
    	
    	
    	if($stocks)
    		$stocks->total = $stocks ? 1 : 0;
    	else
    		$stocks['total'] = 0;
    	$data['stocks'] = (array)$stocks;    	
    	
    	if(is_object($stocks))
    		$reportRecords[] = (array)$stocks;
    	
    	
    	// Get Cusomter List
    	$prepare = $this->getPreparedVanInventory();
    	if($reports)
    	{
    		$limit = config('system.report_limit_xls');
    		$results = $prepare->skip($offset)->take($limit)->get();
    	}   
    	else
    	{	 	
    		$results = $prepare->get();
    	}    	

    	$records = [];
    	$tempInvoices = [];
    	$tempReturns = [];
    	//dd($results);
    	foreach($results as $result)
    	{
    		$sales = \DB::table('txn_sales_order_detail')
			    		->select(['item_code','served_qty'])
			    		->where('so_number','=',$result->so_number)
			    		->whereIn('item_code',$codes)
			    		->get();

    		foreach($sales as $item)
    		{
    			$result->{'code_'.$item->item_code} = '('.$item->served_qty.')';
    			if(isset($tempInvoices['code_'.$item->item_code]))
    				$tempInvoices['code_'.$item->item_code] += $item->served_qty;
    			else
    				$tempInvoices['code_'.$item->item_code] = $item->served_qty;    			
    		}	
    		
    		if(isset($temp['code_'.$result->item_code]))
    			$tempReturns['code_'.$result->item_code] += (int)$result->quantity;
    		else
    			$tempReturns['code_'.$result->item_code] = $result->quantity;
    		
    		$records[] = $result;
    		$reportRecords[] = (array)$result;
    	}
    	
    	// Compute Stock on Hand
    	$stockOnHand = [];    	
    	$hasStockOnHand = false; 
    	foreach($codes as $code)
    	{
    		$code = 'code_'.$code;
    		if(!isset($tempActualCount[$code]))
    			$tempActualCount[$code] = 0;
    		if(!isset($tempStockTransfer[$code]))
    			$tempStockTransfer[$code] = 0;
    		if(!isset($tempReturns[$code]))
    			$tempReturns[$code] = 0;
    		if(!isset($tempInvoices[$code]))
    			$tempInvoices[$code] = 0;
    		
    		$stockOnHand[$code] = $tempActualCount[$code] + $tempStockTransfer[$code] + $tempReturns[$code] - $tempInvoices[$code];
    		$stockOnHand[$code] = (!$stockOnHand[$code]) ? '' : $stockOnHand[$code];
    		$stockOnHand[$code] = $this->negate($stockOnHand[$code]);
    		
    		if($stockOnHand[$code])
    			$hasStockOnHand = true;
    	}
    	
    	$data['records'] = $records;
    	$data['total'] = $reports ? count($records) : count($results);
    	
    	$data['stock_on_hand'] = $stockOnHand;
    	if($hasStockOnHand && $data['stocks']['total'])
    		$reportRecords[] = array_merge(['customer_name'=>'<strong>Stock On Hand</strong>'],$stockOnHand);
    	
    	// Short over stocks
    	$shortOverStocks = [];
    	$displayShort = false;
    	foreach($stockOnHand as $code => $stock)
    	{
    		if($replenishment && isset($replenishment->{$code}))
    		{    			
    			$shortOverStocks[$code] = isset($stockOnHand[$code]) ? ($replenishment->{$code}-$stockOnHand[$code]) : $replenishment->{$code};
    			$shortOverStocks[$code] = $shortOverStocks[$code] == 0 ? '' : $shortOverStocks[$code];
    			$shortOverStocks[$code] = $this->negate($shortOverStocks[$code]);
    			
    			if($shortOverStocks[$code] && $data['stocks']['total'])
    				$displayShort = true;
    		}    		    		
    	}
    	$shortOverStocks['total'] = $displayShort ? 1 : 0;
    	$data['short_over_stocks'] = $shortOverStocks;
    	if($displayShort)
    		$reportRecords[] = array_merge(['customer_name'=>'<strong>Short/Over Stocks</strong>'],$shortOverStocks);
    	
    	unset($replenishment->replenishment_date);
    	unset($replenishment->reference_number);	    	    
    	
    	return ($reports) ? $reportRecords : response()->json($data);
    }
    
    
    /**
     * Get previous stock on hand value
     * @param unknown $dateFrom
     * @return multitype:
     */
    public function getPreviousStockOnHand($dateFrom)
    {
    	$itemCodes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code');    	 
    	foreach($itemCodes as $item)
    	{
    		$codes[] = $item->item_code;
    	}
    	
    	// Get previous stock transfer
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->select([\DB::raw('DATE(sfa_modified_date) sfa_modified_date'),'stock_transfer_number'])
    					->where(\DB::raw('DATE(sfa_modified_date)'),'<',$dateFrom)
    					->where('salesman_code','=',$this->request->get('salesman_code'));
    	
    	$stockTransferNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $stockTransferNumFilter->addFilter($prepare,'stock_transfer_number');
    	$prepare = $prepare->orderBy('sfa_modified_date','desc');
    	
    	$stockTransfer = $prepare->first();
    					
    	if(!$stockTransfer)
    		return [];
    	
    	// Stock Transfer
    	$tempStockTransfer = [];
    	if($stockTransfer)
    	{
    		$stockItems = $this->getVanInventoryStockItems($stockTransfer->stock_transfer_number, $codes);
    		foreach($stockItems as $item)
    		{
    			$tempStockTransfer['code_'.$item->item_code] = $item->quantity;
    		}
    	}
    	
    	$prevDate = date('Y-m-d', strtotime('-1 day', strtotime($dateFrom)));
    	
    	// Beginning Balance / Actual Count
    	// Get Replenishment data 
    	$prepare = \DB::table('txn_replenishment_header')
    					->select('reference_number')
    					->whereBetween(\DB::raw('DATE(replenishment_date)'),[$stockTransfer->sfa_modified_date,$prevDate]);
    	
    	$referenceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceNumFilter->addFilter($prepare,'reference_number');
    	$replenishment = $prepare->get(); 
    	
    	$tempActualCount = [];
    	if($replenishment)
    	{
    		$refNumbers = [];
    		foreach($replenishment as $rep)
    			$refNumbers[] = $rep->reference_number;
    			
    		$replenishmentItems = \DB::table('txn_replenishment_detail')
			    			->select(['item_code','quantity','replenishment_detail_id'])
			    			->whereIn('item_code',$codes)
			    			->whereIn('reference_number',$refNumbers)
			    			->get();
    		foreach($replenishmentItems as $item)
    		{
    			if(!isset($tempActualCount['code_'.$item->item_code]))
    				$tempActualCount['code_'.$item->item_code] = 0;
    			$tempActualCount['code_'.$item->item_code] += $item->quantity;
    		}	
    		    		    			    			    
    	}
    			 
    	
    	// Get Invoice 
    	$status = $this->request->get('status') ? $this->request->get('status') : 'A';
    	$item_codes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code', $status);
    	$itemCodes = [];
    	foreach($item_codes as $item)
    	{
    		$itemCodes[] = $item->item_code;
    	}
    	
    	/* $prepare = \DB::table('txn_sales_order_header')
    				->distinct()    		
 				   	->select(['txn_sales_order_header.so_number','txn_return_detail.quantity','txn_sales_order_detail.item_code'])
 				   	->leftJoin('txn_sales_order_detail','txn_sales_order_header.so_number','=','txn_sales_order_detail.so_number')
 				   	->leftJoin('txn_return_detail','txn_sales_order_header.reference_num','=','txn_return_detail.reference_num')
 				   	->where('txn_sales_order_header.salesman_code','=',$this->request->get('salesman_code'))
 				   	->whereIn('txn_sales_order_detail.item_code',$itemCodes)
 				   	->whereBetween(\DB::raw('DATE(txn_sales_order_header.so_date)'),[$stockTransfer->sfa_modified_date,$prevDate]); */
    	$prepare = $this->getPreparedVanInventory(true)
    				->whereBetween(\DB::raw('DATE(txn_sales_order_header.so_date)'),[$stockTransfer->sfa_modified_date,$prevDate]);
    	$invoices = $prepare->get();
    	//dd($invoices);
    	foreach($invoices as $result)
    	{
    		$sales = \DB::table('txn_sales_order_detail')
			    		->select(['item_code','served_qty'])
			    		->where('so_number','=',$result->so_number)
			    		->whereIn('item_code',$itemCodes)
			    		->get();

    		foreach($sales as $item)
    		{
    			if(!isset($tempInvoices['code_'.$item->item_code]))
    				$tempInvoices['code_'.$item->item_code] = 0;
    			$tempInvoices['code_'.$item->item_code] += $item->served_qty;    			
    		}	
    		
    		if(isset($temp['code_'.$result->item_code]))
    			$tempReturns['code_'.$result->item_code] += (int)$result->quantity;
    		else
    			$tempReturns['code_'.$result->item_code] = $result->quantity;
    		
    	}
    	
    	// Compute Stock on Hand
    	$stockOnHand = [];    	 
    	foreach($codes as $code)
    	{
    		$code = 'code_'.$code;
    		if(!isset($tempActualCount[$code]))
    			$tempActualCount[$code] = 0;
    		if(!isset($tempStockTransfer[$code]))
    			$tempStockTransfer[$code] = 0;
    		if(!isset($tempReturns[$code]))
    			$tempReturns[$code] = 0;
    		if(!isset($tempInvoices[$code]))
    			$tempInvoices[$code] = 0;
    		
    		$stockOnHand[$code] = $tempActualCount[$code] + $tempStockTransfer[$code] + $tempReturns[$code] - $tempInvoices[$code];
    		$stockOnHand[$code] = (!$stockOnHand[$code]) ? '' : $stockOnHand[$code];
    		$stockOnHand[$code] = $this->negate($stockOnHand[$code]);
    	}
    	
    	return $stockOnHand;
    }
    
    
    /**
     * Convert - to parenthisis
     * @param unknown $val
     * @return unknown
     */
    public function negate($val)
    {
    	if($val < 0)
    	{
    		$val = str_replace('-', '(', $val) . ')';
    	}
    	return $val;
    }
    
    /**
     * Return prepared statement for van inventory stocks
     * @return unknown
     */
    public function getPreparedVanInventoryStocks()
    {
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->selectRaw('modified_date transaction_date,stock_transfer_number');
    	 
    	$transactionFilter = FilterFactory::getInstance('Date');
    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
		    			function($self, $model){
		    				return $model->where(\DB::raw('DATE(txn_stock_transfer_in_header.sfa_modified_date)'),'=',$self->getValue());
		    			});
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	
    	$stockTransferNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $stockTransferNumFilter->addFilter($prepare,'stock_transfer_number');
    	
    	return $prepare;
    			 
    }
    
    /**
     * Return prepared statement for van inventory
     * @return unknown
     */
    public function getPreparedVanInventory($noTransaction=false)
    {
    	$select = '
    			   app_customer.customer_name,
				   txn_sales_order_header.so_date invoice_date,
				   txn_sales_order_header.invoice_number,
    			   txn_sales_order_header.so_number,
    			   txn_return_header.return_slip_num,
    			   txn_return_detail.item_code,
    			   txn_return_detail.quantity,
    			   IF(txn_sales_order_header.updated_by,\'modified\',\'\') updated
    			';				 
    	 
    	$prepare = \DB::table('txn_sales_order_header')
    				->selectRaw($select)
    				->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')			    	
			    	->leftJoin('txn_return_header', function ($join){
			    		$join->on('txn_sales_order_header.reference_num','=','txn_return_header.reference_num')
			    		->where('txn_sales_order_header.salesman_code','=','txn_return_header.salesman_code');
			    	})
			    	->leftJoin('txn_return_detail','txn_return_header.return_txn_number','=','txn_return_detail.return_txn_number');
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	 
    	if(!$noTransaction)
    	{
	    	$transactionFilter = FilterFactory::getInstance('Date');
	    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
	    			function($self, $model){
	    				return $model->where(\DB::raw('DATE(txn_sales_order_header.so_date)'),'=',$self->getValue());
	    			});
    	}
    	 
    	$invoiceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number');
    	
    	$returnSlipNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $returnSlipNumFilter->addFilter($prepare,'return_slip_num',
    					function($self,$model){    						
    						return $model->where('txn_return_header.return_slip_num','LIKE',$self->getValue().'%');
    				});
    	
    	/* $invoiceFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceFilter->addFilter($prepare,'invoice_date'); */
    	 
    	/* $postingFilter = FilterFactory::getInstance('DateRange');
    	 $prepare = $postingFilter->addFilter($prepare,'posting_date',
	    				function($self, $model){
	    						return $model->where(\DB::raw('DATE(txn_sales_order_header.sfa_modified_date)'),'=',$self->getValue());	
    				});
    	 */ 
    	/* $typeFilter = FilterFactory::getInstance('Select');
    	$prepare = $typeFilter->addFilter($prepare,'type',
    					function($self, $model){
    						return $model->where('app_area.area_code','=',$self->getValue());	
    				}); */
    	
    	/* $status = $this->request->get('status') ? $this->request->get('status') : 'A';
    	$item_codes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code', $status);
    	$codes = [];
    	foreach($item_codes as $item)
    	{
    		$codes[] = $item->item_code;
    	}
    	$prepare = $prepare->whereIn('txn_sales_order_detail.item_code',$codes); */    	
    	
    	return $prepare;
    }
    
    /**
     * Get Unpaid Invoice records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnpaidInvoice()
    {
    	$prepare = $this->getPreparedUnpaidInvoice();
    	
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedUnpaidInvoice(true);
    		$data['summary'] = $prepare->first();
    	}
    	
    	$data['total'] = $result->total();
    
    	return response()->json($data);
    }
    
    /**
     * Get prepared Unpadin Invoice
     * @param string $summary
     * @return unknown
     */
    public function getPreparedUnpaidInvoice($summary=false)
    {
    	if($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to'))
    	{
    		$from = date_create($this->request->get('invoice_date_from'));
            $to = date_create($this->request->get('invoice_date_to'));
            $filterInvoice = "DATE(%sinvoice_date) BETWEEN '".date_format($from, 'Y-m-d')."' and '".date_format($to, 'Y-m-d')."'";
    	}
    	else
    	{
    		$filterInvoice = 'DATE(%sinvoice_date) <= \''.date('Y-m-d').'\'';
    	}
    	
    	// VW_INV temporary table
    	$queryInv = '
    		(select salesman_code, customer_code, invoice_number, sum(coalesce(invoice_amount,0)) as invoice_amount
            from (
                    select salesman_code, customer_code, invoice_number, original_amount as invoice_amount
                  	from txn_invoice ti where '.sprintf($filterInvoice,'ti.').'
                  	and ti.document_type = \'I\'
                  	and ti.status = \'A\'		
                  	and ti.customer_code in (select customer_code from app_salesman_customer where salesman_code = ti.salesman_code and status =\'A\')
      
                  	UNION ALL
    	
                  	select tsoh.salesman_code, tsoh.customer_code, tsoh.invoice_number,
                  	case when sum(so_net_amt - coalesce(tsohd.served_deduction_amount,0) - (coalesce(trd.rtn_net_amt,0) - coalesce(trhd.deduction_amount,0))) <= 0 then 0 else
                  			      sum(so_net_amt - coalesce(tsohd.served_deduction_amount,0) - (coalesce(trd.rtn_net_amt,0) - coalesce(trhd.deduction_amount,0))) end as invoice_amount
                  	from txn_sales_order_header tsoh
			
                  	inner join
					         (select reference_num,round(sum(gross_served_amount + vat_amount - discount_amount),2) as so_net_amt
							         from txn_sales_order_detail
							         group by reference_num) tsod
					         on tsoh.reference_num = tsod.reference_num
			
        					left join
        					(select reference_num,round(sum(served_deduction_amount),2) as served_deduction_amount
        							from txn_sales_order_header_discount group by reference_num) tsohd
					         on tsoh.reference_num = tsohd.reference_num
			
        					left join
        					(select reference_num,round(sum(gross_amount + vat_amount - discount_amount),2) as rtn_net_amt
        							from txn_return_detail group by reference_num) trd
        					on tsoh.reference_num = trd.reference_num
			
        					left join txn_return_header_discount trhd
        					on tsoh.reference_num = trhd.reference_num
			
                  where '.str_replace('invoice_date', 'so_date', sprintf($filterInvoice,'tsoh.')).'
                  and tsoh.customer_code in (select customer_code from app_salesman_customer where salesman_code = tsoh.salesman_code and status =\'A\')
                  and tsod.so_net_amt > 0
                  group by tsoh.salesman_code, tsoh.customer_code, tsoh.invoice_number
               ) vw_inv
              group by salesman_code, customer_code, invoice_number )
    		  vw_inv
    			';    	
    	 
    	// VW_COL temporary table
    	$queryCol = '
    			 (select tch.salesman_code, tch.customer_code, tci.invoice_number, round(sum(tci.applied_amount),2) as applied_amount 
                    from txn_collection_header tch
                    inner join txn_collection_invoice tci
                    on tch.reference_num = tci.reference_num
                    and tch.collection_num = tci.collection_num
                    where '.str_replace('invoice_date', 'or_date', sprintf($filterInvoice,'tch.')).'
                    group by tch.salesman_code, tch.customer_code, tci.invoice_number
    			) vw_col
    			';
    	
    	$select = '
    			  app_salesman.salesman_name,
			      app_area.area_name,
			      app_customer.customer_code,
			      app_customer.customer_name,
			      f.remarks,
			      vw_inv.invoice_number,
			      txn_sales_order_header.so_date invoice_date,
			      coalesce(vw_inv.invoice_amount,0) original_amount,
			      coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0) balance_amount
    			';
    	if($summary)
    	{
    		$select = '
			      ROUND(SUM(coalesce(vw_inv.invoice_amount,0)),0) original_amount,
			      ROUND(SUM(coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0)),0) balance_amount
    			';
    	}
    	
    	$prepare = \DB::table(\DB::raw($queryInv))
    				->selectRaw($select)
    				->leftjoin(\DB::raw($queryCol),function($join){
    					$join->on('vw_col.salesman_code','=','vw_inv.salesman_code');
    					$join->on('vw_col.customer_code','=','vw_inv.customer_code');
    					$join->on('vw_col.invoice_number','=','vw_inv.invoice_number');
    				})
    				->join('app_salesman',function($join){
    					$join->on('app_salesman.salesman_code','=','vw_inv.salesman_code');
    					$join->where('app_salesman.status','=','A');    					
    				})
    				->join('app_customer',function($join){
    					$join->on('app_customer.customer_code','=','vw_inv.customer_code');
    					$join->where('app_customer.status','=','A');
    				})
    				->join('app_area',function($join){
    					$join->on('app_area.area_code','=','app_customer.area_code');
    					$join->where('app_area.status','=','A');
    				})
    				->join('txn_sales_order_header','txn_sales_order_header.invoice_number','=','vw_inv.invoice_number')
    				->leftJoin(\DB::raw('
			    			(select remarks,reference_num
			    			 from txn_evaluated_objective
			    			 group by reference_num) f'), function($join){
    							    			 	$join->on('txn_sales_order_header.reference_num','=','f.reference_num');
    							    			 }
    				);    	
    	
    	
    	$prepare = $prepare->where(\DB::raw('coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0)'),'>','0');
    	
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('vw_inv.salesman_code','=',$self->getValue());
    			});
    	
    	$companyCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('vw_inv.customer_code','like',$self->getValue().'%');
    			});
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer',
    			function($self, $model){
    				return $model->where('vw_inv.customer_code','=',$self->getValue());
    			});
    	 
    	return $prepare;
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
    
    	$prepare = $this->getPreparedSalesReportMaterial(); 
    		
    	$result = $this->paginate($prepare);    	    	
    	$data['records'] = $result->items();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedSalesReportMaterial(true);
    		$data['summary'] = $prepare->first();
    	}
    	    	
    	$data['total'] = $result->total();
    
    	return response()->json($data);
    }
    
    /**
     * Returns the prepared statement for Sales Report Per Material
     * @return Builder 
     */
    public function getPreparedSalesReportMaterial($summary=false)
    {
    	$select = 'txn_sales_order_header.sales_order_header_id,
    			   txn_sales_order_header.so_number,
			  	   txn_sales_order_header.reference_num,
				   txn_activity_salesman.activity_code,
				   txn_sales_order_header.customer_code,
				   app_customer.customer_name,
    			   remarks.evaluated_objective_id,
				   remarks.remarks,
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
    			   txn_sales_order_detail.served_qty quantity,
    			   txn_return_detail.return_detail_id,				   
				   txn_return_detail.condition_code,
    			   txn_sales_order_detail.sales_order_detail_id,
				   txn_sales_order_detail.uom_code,
				   txn_sales_order_detail.gross_served_amount,
				   txn_sales_order_detail.vat_amount,
				   txn_sales_order_detail.discount_rate,
				   txn_sales_order_detail.discount_amount,
    			   tsohd.collective_discount_rate,	
    			   tsohd.collective_discount_amount,
      			   tsohd.discount_reference_num,
    			   tsohd.discount_remarks,
    			   tsohd.collective_deduction_rate,	
    			   tsohd.collective_deduction_amount,
      			   tsohd.deduction_reference_num,
    			   tsohd.deduction_remarks,
    			   tsohd.collective_deduction_amount,
    			   ((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount + tsohd.collective_discount_amount + tsohd.collective_deduction_amount)) total_invoice,
				   IF(txn_sales_order_header.updated_by,\'modified\',
    						IF(txn_sales_order_detail.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)
    					
    			   ) updated  		
    			';
    	 
    	if($summary)
    	{
    		$select = '
				   ROUND(SUM(txn_sales_order_detail.served_qty),0) quantity,
				   ROUND(SUM(txn_sales_order_detail.gross_served_amount),0) gross_served_amount,
    			   ROUND(SUM(txn_sales_order_detail.discount_amount),0) discount_amount,
				   ROUND(SUM(txn_sales_order_detail.vat_amount),0) vat_amount,
				   ROUND(SUM(tsohd.collective_discount_amount),0) collective_discount_amount,
    			   ROUND(SUM(tsohd.collective_deduction_amount),0) collective_deduction_amount,
				   ROUND(SUM((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount + tsohd.collective_discount_amount + tsohd.collective_deduction_amount)),0) total_invoice	
    			';
    	}
    	
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
			    	->leftJoin('txn_sales_order_detail','txn_sales_order_header.reference_num','=','txn_sales_order_detail.reference_num')
			    	->leftJoin('app_item_master','txn_sales_order_detail.item_code','=','app_item_master.item_code')
			    	//->leftJoin('txn_sales_order_header_discount','txn_sales_order_header.reference_num','=','txn_sales_order_header_discount.reference_num')
			    	->leftJoin(\DB::raw('
			    			(select reference_num,
			    			served_deduction_rate as collective_deduction_rate,
			    			served_deduction_rate as collective_discount_rate,
			    			ref_no as discount_reference_num,
			    			remarks as discount_remarks,
			    			ref_no as deduction_reference_num,
			    			remarks as deduction_remarks,
							sum(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_deduction_amount,
							sum(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_discount_amount
							from txn_sales_order_header_discount
							group by reference_num) tsohd'), function($join){
			    				    			 	$join->on('txn_sales_order_header.reference_num','=','tsohd.reference_num');
			    				    			 }
			    	)
			    	->leftJoin(\DB::raw('
			    			(select evaluated_objective_id,remarks,reference_num,updated_by 
			    			 from txn_evaluated_objective
			    			 group by reference_num) remarks'), function($join){
			    			 	$join->on('txn_sales_order_header.reference_num','=','remarks.reference_num');
			    			 }
			    	  );
			    	

		$salesmanFilter = FilterFactory::getInstance('Select');
		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
			    	
		$areaFilter = FilterFactory::getInstance('Select');
		$prepare = $areaFilter->addFilter($prepare,'area',
			    			function($self, $model){
			    				return $model->where('app_area.area_code','=',$self->getValue());
			    			});
			    	 
		$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){								
								return $model->where('txn_sales_order_header.customer_code','like',$self->getValue().'%');
							});
			    	 
		$invoiceNumFilter = FilterFactory::getInstance('Text');
		$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
						function($self, $model){
							return $model->where('txn_sales_order_header.invoice_number','LIKE',$self->getValue().'%');							
					});
		
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
		$prepare = $invoiceDateFilter->addFilter($prepare,'return_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_sales_order_header.so_date)'),$self->formatValues($self->getValue()));
			    			});
			    	
		$postingFilter = FilterFactory::getInstance('DateRange');
		$prepare = $postingFilter->addFilter($prepare,'posting_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_sales_order_header.sfa_modified_date)'),$self->formatValues($self->getValue()));
			    			});

		return $prepare;	    	
    }
    
    
    
    /**
     * Get Sales Report Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportPeso()
    {
    	$prepare = $this->getPreparedSalesReportPeso();
    	 
    	$result = $this->paginate($prepare);    	
    	$data['records'] = $result->items();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedSalesReportPeso(true);
    		$data['summary'] = $prepare->first();
    	}
    	
    	$data['total'] = $result->total();
    	
    	return response()->json($data);
    }
    
    /**
     * Return Sales Report per peso prepared statement
     * @return unknown
     */
    public function getPreparedSalesReportPeso($summary=false)
    {
    	$select = 'txn_sales_order_header.sales_order_header_id,	
    			   txn_sales_order_header.so_number,
			  	   txn_sales_order_header.reference_num,
				   txn_activity_salesman.activity_code,
				   txn_sales_order_header.customer_code,
				   app_customer.customer_name,
				   remarks.evaluated_objective_id,
				   remarks.remarks,
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
				   tsohd.collective_discount_rate,	
    			   tsohd.collective_discount_amount,
      			   tsohd.discount_reference_num,
    			   tsohd.discount_remarks,
    			   tsohd.collective_deduction_rate,	
    			   tsohd.collective_deduction_amount,
      			   tsohd.deduction_reference_num,
    			   tsohd.deduction_remarks,
    			   tsohd.collective_deduction_amount,
    			   ((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount + tsohd.collective_discount_amount + tsohd.collective_deduction_amount)) total_invoice,
	    		   IF(txn_sales_order_header.updated_by,\'modified\',
	    					IF(txn_sales_order_detail.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)

	    		   ) updated
    			';

    	if($summary)
    	{
    		$select = '
				   ROUND(SUM(txn_sales_order_detail.gross_served_amount),0) gross_served_amount,
				   ROUND(SUM(txn_sales_order_detail.vat_amount),0) vat_amount,
				   ROUND(SUM(txn_sales_order_detail.discount_amount),0) discount_amount,
				   ROUND(SUM(tsohd.collective_discount_amount),0) collective_discount_amount,
    			   ROUND(SUM(tsohd.collective_deduction_amount),0) collective_deduction_amount,
				   ROUND(SUM((txn_sales_order_detail.gross_served_amount + txn_sales_order_detail.vat_amount) - (txn_sales_order_detail.discount_amount + tsohd.collective_discount_amount + tsohd.collective_deduction_amount)),0) total_invoice
    			';
    	}
    	$prepare = \DB::table('txn_sales_order_header')
			    	->selectRaw($select)
			    	->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')
			    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
			    	->leftJoin('app_salesman','txn_sales_order_header.salesman_code','=','app_salesman.salesman_code')
			    	->leftJoin('txn_activity_salesman', function($join){
			    		$join->on('txn_sales_order_header.reference_num','=','txn_activity_salesman.reference_num');
			    		$join->on('txn_sales_order_header.salesman_code','=','txn_activity_salesman.salesman_code');
			    	})
			    	//->leftJoin('txn_sales_order_header_discount','txn_sales_order_header.reference_num','=','txn_sales_order_header_discount.reference_num')
			    	->leftJoin(\DB::raw('
			    			(select reference_num,
			    			served_deduction_rate as collective_deduction_rate,
			    			served_deduction_rate as collective_discount_rate,
			    			ref_no as discount_reference_num,
			    			remarks as discount_remarks,
			    			ref_no as deduction_reference_num,
			    			remarks as deduction_remarks,
							sum(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_deduction_amount,
							sum(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_discount_amount
							from txn_sales_order_header_discount
							group by reference_num) tsohd'), function($join){
			    										$join->on('txn_sales_order_header.reference_num','=','tsohd.reference_num');
			    									}
			    	)
			    	->leftJoin('txn_sales_order_detail','txn_sales_order_header.reference_num','=','txn_sales_order_detail.reference_num')
			    	->leftJoin(\DB::raw('
			    			(select evaluated_objective_id,remarks,reference_num,updated_by
			    			 from txn_evaluated_objective
			    			 group by reference_num) remarks'), function($join){
			    				    			 	$join->on('txn_sales_order_header.reference_num','=','remarks.reference_num');
			    				    			 }
			    	);

		$salesmanFilter = FilterFactory::getInstance('Select');
		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
			    	 
		$areaFilter = FilterFactory::getInstance('Select');
		$prepare = $areaFilter->addFilter($prepare,'area',
			    			function($self, $model){
			    				return $model->where('app_area.area_code','=',$self->getValue());
			    			});

		$invoiceNumFilter = FilterFactory::getInstance('Text');
		$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
				function($self, $model){
					return $model->where('txn_sales_order_header.invoice_number','LIKE',$self->getValue().'%');
				});
		
		$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('txn_sales_order_header.customer_code','like',$self->getValue().'%');
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
		$prepare = $invoiceDateFilter->addFilter($prepare,'return_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_sales_order_header.so_date)'),$self->formatValues($self->getValue()));
			    			});
			    	 
		$postingFilter = FilterFactory::getInstance('DateRange');
		$prepare = $postingFilter->addFilter($prepare,'posting_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_sales_order_header.sfa_modified_date)'),$self->formatValues($self->getValue()));
			    			});			    	
		return $prepare;
    }
    
    /**
     * Get Return Material
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnMaterial()
    {
    
    	$prepare = $this->getPreparedReturnMaterial();    		
    	
    	$result = $this->paginate($prepare);        	
    	$data['records'] = $result->items();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedReturnMaterial(true);
    		$data['summary'] = $prepare->first();
    	}
    	    	
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    }
    
    /**
     * Return prepared statemen for return material
     * @return unknown
     */
    public function getPreparedReturnMaterial($summary=false)
    {
    	$select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
				remarks.remarks,
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
				txn_return_detail.gross_amount,
				txn_return_detail.vat_amount,
				\'0\' discount_rate,
				txn_return_detail.discount_amount,
				trhd.collective_discount_rate,	
    			trhd.collective_discount_amount,
      			trhd.discount_reference_num,
    			trhd.discount_remarks,
    			((txn_return_detail.gross_amount + txn_return_detail.vat_amount) - (txn_return_detail.discount_amount + trhd.collective_discount_amount)) total_invoice,
    			IF(txn_return_header.updated_by,\'modified\',
	    					IF(txn_return_detail.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)

	    		) updated 
    			';
    	 
    	if($summary)
    	{
    		$select = '
    			ROUND(SUM(txn_return_detail.quantity),0) quantity,
				ROUND(SUM(txn_return_detail.gross_amount),0) gross_served_amount,
				ROUND(SUM(txn_return_detail.vat_amount),0) vat_amount,
				ROUND(SUM(txn_return_detail.discount_amount),0) discount_amount,
				ROUND(SUM(trhd.collective_discount_amount),0) collective_discount_amount,
    			ROUND(SUM((txn_return_detail.gross_amount + txn_return_detail.vat_amount) - (txn_return_detail.discount_amount + trhd.collective_discount_amount)),0) total_invoice    			
    			';
    	}
    	
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
			    	->leftJoin(\DB::raw('
			    			(select reference_num,
			    			deduction_rate as collective_discount_rate,
			    			ref_no as discount_reference_num,
			    			remarks as discount_remarks,
							sum(case when deduction_code <> \'EWT\' then coalesce(deduction_amount,0) else 0 end) as collective_discount_amount
							from txn_return_header_discount
							group by reference_num) trhd'), function($join){
			    									$join->on('txn_return_header.reference_num','=','trhd.reference_num');
			    								}
			    	)
			    	->leftJoin(\DB::raw('
			    			(select evaluated_objective_id,remarks,reference_num,updated_by
			    			 from txn_evaluated_objective
			    			 group by reference_num) remarks'), function($join){
			    				    			 	$join->on('txn_return_header.reference_num','=','remarks.reference_num');
			    				    			 }
			    	);

		$salesmanFilter = FilterFactory::getInstance('Select');
		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
			    	
		$areaFilter = FilterFactory::getInstance('Select');
		$prepare = $areaFilter->addFilter($prepare,'area',
			    			function($self, $model){
			    				return $model->where('app_area.area_code','=',$self->getValue());
			    			});
			    	 
		$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('txn_return_header.customer_code','like',$self->getValue().'%');
							});

		$invoiceNumFilter = FilterFactory::getInstance('Text');
		$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
				function($self, $model){
					return $model->where('txn_return_header.return_slip_num','LIKE',$self->getValue().'%');
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
		$prepare = $invoiceDateFilter->addFilter($prepare,'return_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_return_header.return_date)'),$self->formatValues($self->getValue()));
			    			});
			    	
		$postingFilter = FilterFactory::getInstance('DateRange');
		$prepare = $postingFilter->addFilter($prepare,'posting_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(txn_return_header.sfa_modified_date)'),$self->formatValues($self->getValue()));
			    			});
			    	
		return $prepare;	    	
    	
    }
    
    /**
     * Get Return Per Peso
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReturnPeso()
    {    
    	$prepare = $this->getPreparedReturnPeso();    	
    	$result = $this->paginate($prepare);    	
    	$data['records'] = $result->items();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedReturnPeso(true);
    		$data['summary'] = $prepare->first();
    	}    	
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    }
    
    /**
     * Return prepared statement for return per peso
     * @return unknown
     */
    public function getPreparedReturnPeso($summary=false)
    {
    	$select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
				remarks.remarks,
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
				txn_return_detail.gross_amount,
				txn_return_detail.vat_amount,
				\'0\' discount_rate,
				txn_return_detail.discount_amount,
				trhd.collective_discount_rate,	
    			trhd.collective_discount_amount,
      			trhd.discount_reference_num,
    			trhd.discount_remarks,
    			((txn_return_detail.gross_amount + txn_return_detail.vat_amount) - (txn_return_detail.discount_amount + trhd.collective_discount_amount + trhd.collective_deduction_amount)) total_invoice,
	    		IF(txn_return_header.updated_by,\'modified\',
	    					IF(txn_return_detail.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)

	    		) updated
    			';

    	if($summary)
    	{
    		$select = '
    			ROUND(SUM(txn_return_detail.gross_amount),0) gross_amount,
				ROUND(SUM(txn_return_detail.vat_amount),0) vat_amount,
				ROUND(SUM(txn_return_detail.discount_amount),0) discount_amount,
				ROUND(SUM(trhd.collective_discount_amount),0) collective_discount_amount,
    			ROUND(SUM(trhd.collective_deduction_amount),0) collective_deduction_amount,
				ROUND(SUM((txn_return_detail.gross_amount + txn_return_detail.vat_amount) - (txn_return_detail.discount_amount + trhd.collective_discount_amount + trhd.collective_deduction_amount)),0) total_invoice
    			';
    	}
    	
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
			    	->leftJoin(\DB::raw('
			    			(select reference_num,
			    			deduction_rate as collective_deduction_rate,
			    			deduction_rate as collective_discount_rate,
			    			ref_no as discount_reference_num,
			    			remarks as discount_remarks,
			    			ref_no as deduction_reference_num,
			    			remarks as deduction_remarks,
							sum(case when deduction_code = \'EWT\' then coalesce(deduction_amount,0) else 0 end) as collective_deduction_amount,
							sum(case when deduction_code <> \'EWT\' then coalesce(deduction_amount,0) else 0 end) as collective_discount_amount
							from txn_return_header_discount
							group by reference_num) trhd'), function($join){
			    									$join->on('txn_return_header.reference_num','=','trhd.reference_num');
			    								}
			    	)
			    	->leftJoin(\DB::raw('
			    			(select evaluated_objective_id,remarks,reference_num,updated_by
			    			 from txn_evaluated_objective
			    			 group by reference_num) remarks'), function($join){
			    				    			 	$join->on('txn_return_header.reference_num','=','remarks.reference_num');
			    				    			 }
			    	);			    	
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('app_area.area_code','=',$self->getValue());
    			});
    	 
    	$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('txn_return_header.customer_code','like',$self->getValue().'%');
							});
    	 
		$invoiceNumFilter = FilterFactory::getInstance('Text');
		$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
				function($self, $model){
					return $model->where('txn_return_header.return_slip_num','LIKE',$self->getValue().'%');
				});
		
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'return_date');
    	
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(txn_return_header.sfa_modified_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	return $prepare;
    }
    
    /**
     * Get Cusomter List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerList()
    {    
    	$prepare = $this->getPreparedCustomerList();
    	
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    	
    }
    
    /**
     * Get Customer List prepared statement
     */
    public function getPreparedCustomerList()
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
    	 
    	$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('app_customer.customer_code','like',$self->getValue().'%');
							});
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	
    	return $prepare;
    }
    
    /**
     * Get Salesman List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesmanList()
    {    
    	$prepare = $this->getPreparedSalesmanList();        	
    	
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    
    	return response()->json($data);
    	
    }
    
    /**
     * Return Salesman List prepared statement
     * @return unknown
     */
    public function getPreparedSalesmanList()
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
    	 
    	$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('app_customer.customer_code','like',$self->getValue().'%');
							});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	
    	return $prepare;
    }
    
    /**
     * Get Material Price List
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMaterialPriceList()
    {
    	$prepare = $this->getPreparedMaterialPriceList();    	
    	 
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    
    	return response()->json($data);
    	 
    }

    /**
     * Return prepared statement for material price list
     * @return unknown
     */
    public function getPreparedMaterialPriceList()
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
    				->distinct()
			    	->selectRaw($select)
			    	->leftJoin('app_item_master_uom','app_item_master.item_code','=','app_item_master_uom.item_code')
			    	->leftJoin('app_item_price','app_item_master.item_code','=','app_item_price.item_code')
			    	->leftJoin(\DB::raw('
			    			(select customer_price_group, area_code from app_customer group by customer_price_group) app_customer 
			    			'), function($join){
			    				$join->on('app_customer.customer_price_group','=','app_item_price.customer_price_group');
			    			})
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
    	
    	$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){
								return $model->where('app_customer.customer_code','like',$self->getValue().'%');
							});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	
    	return $prepare;
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
    		case 'salescollectionreport':
    			return $this->getSalesCollectionReportColumns();
    		case 'salescollectionposting':
    			return $this->getSalesCollectionPostingColumns();
    		case 'salescollectionsummary':
    			return $this->getSalesCollectionSummaryColumns();
    		case 'vaninventorycanned':
    			return $this->getVanInventoryColumns();
    		case 'vaninventoryfrozen':
    			return $this->getVanInventoryColumns('frozen');
    		case 'unpaidinvoice':
    			return $this->getUnpaidColumns();
    		case 'bir':
    			return $this->getBirColumns();
    		case 'salesreportpermaterial':
    			return $this->getSalesReportMaterialColumns();
    		case 'salesreportperpeso':
    			return $this->getSalesReportPesoColumns();
    		case 'returnpermaterial':
    			return $this->getReturnReportMaterialColumns();
    		case 'returnperpeso':
    			return $this->getReturnReportPerPesoColumns();
    		case 'customerlist':
    			return $this->getCustomerListColumns();
    		case 'salesmanlist':
    			return $this->getSalesmanListColumns();
    		case 'materialpricelist':
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
    			['name'=>'Invoice Discount Amount per Item','sort'=>'so_total_item_discount'],
    			['name'=>'Invoice Discount Amount Collective','sort'=>'so_total_collective_discount'],
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
     * Return unpaid columns
     * @return multitype:multitype:string
     */
    public function getUnpaidColumns()
    {
    	$headers = [
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area Name','sort'=>'area_name'],
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Invoice Number','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Original Amount'],
    			['name'=>'Balance Amount', 'sort'=>'balance_amount']
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
     * Get list of van inventory items
     * @param unknown $type
     * @param string $select
     */
    public function getVanInventoryItems($type, $select='description', $status='A')
    {
    	$prepare = \DB::table('app_item_master')
    					->selectRaw($select);
    	
    	if($type == 'frozen')
    	{
    		$prepare = $prepare->whereRaw('
			    			(segment_code LIKE  \'%FROZEN\' OR segment_code LIKE  \'%KASSEL\' )
								AND STATUS =  \''.$status.'\'
								AND item_code LIKE  \'200%\'
    						');    	    				
    	}
    	else
    	{
    		$prepare = $prepare->whereRaw('
			    			(segment_code LIKE  \'%CANNED\' OR segment_code LIKE  \'%MIXES\' )
								AND STATUS =   \''.$status.'\'
								AND item_code LIKE  \'100%\'
    						');    	
    	}
    	return $prepare->orderBy('item_code')->get();
    }
    /**
     * Get Van Inventory Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVanInventoryColumns($type='canned',$status='A')
    {
    	$headers = [
    			['name'=>'Customer'],
    			//['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Invoice Date'],
    			['name'=>'Invoice No.'],    			 
    			//['name'=>'Return Slip No.','sort'=>'return_slip_num'],
    			['name'=>'Return Slip No.'],
    			['name'=>'Transaction Date'],
    			['name'=>'Stock Transfer No.'],
    			//['name'=>'Replenishment Date','sort'=>'replenishment_date'],
    			['name'=>'Replenishment Date'],
    			['name'=>'Replenishment Number']
    			//['name'=>'Replenishment Number','sort'=>'replenishment_number']
    	];
    	
    	$items = $this->getVanInventoryItems($type,'CONCAT(item_code,\'<br>\',description) name',$status);
    	foreach($items as $item)
    	{
    		$headers[] = ['name'=>$item->name];
    	}
    	
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
    			['name'=>'Invoice No/ Return Slip No.','sort'=>'invoice_number'],
    			['name'=>'Invoice Date/ Return Date','sort'=>'invoice_date'],
    			['name'=>'Invoice/Return Posting Date','sort'=>'invoice_posting_date'],
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
    			['name'=>'Invoice No/ Return Slip No.','sort'=>'invoice_number'],
    			['name'=>'Invoice Date/ Return Date','sort'=>'invoice_date'],
    			['name'=>'Invoice/Return Posting Date','sort'=>'invoice_posting_date'],
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
    			['name'=>'Return Slip No.','sort'=>'return_slip_num'],
    			['name'=>'Return Date','sort'=>'return_date'],
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
    			['name'=>'Return Slip No.','sort'=>'return_slip_num'],
    			['name'=>'Return Date','sort'=>'return_date'],
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
    			['name'=>'Customer Price Group','sort'=>'customer_price_group'],
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
    public function getSalesman($withCode=false)
    {
    	$select = 'salesman_code, salesman_name name';
    	if($withCode)
    	{
    		$select = 'salesman_code, CONCAT(salesman_code,\' - \',salesman_name) name';
    	}
    	
    	return \DB::table('app_salesman')
    				->selectRaw($select)
    				->where('status','=','A')
    				->orderBy('name')    				
    				->lists('name','salesman_code');
    }
    
    
    /**
     * Get Customers
     * @return multitype:
     */
    public function getCustomer()
    {
    	return \DB::table('app_customer')
			    	->where('status','=','A')
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
     * Get Company Code
     * @return multitype:
     */
    public function getCompanyCode()
    {    	
    	return \DB::table('app_customer')
		    			->selectRaw('DISTINCT(SUBSTRING(customer_code,1,4)) company_code')
				    	->orderBy('company_code')
				    	->lists('company_code','company_code');
    }
    
	/**
     * Get Area
     * @return multitype:
     */
    public function getArea($sfiOnly=false)
    {
    	$prepare = \DB::table('app_area')
		    			->where('status','=','A');
    	if($sfiOnly)
    	{
    		$prepare->where('area_name','like','SFI%');
    	}
    	
    	return $prepare->orderBy('area_name')->lists('area_name','area_code');
    }

    /**
     * Get Item Lists
     */
    public function getItems()
    {
    	return \DB::table('app_item_master')
		    			->where('status','=','A')
		    			->orderBy('description')
		    			->lists('description','item_code');
    }
    
    /**
     * Get Item Segment Codes
     */
    public function getItemSegmentCode()
    {
    	return \DB::table('app_item_segment')
    			->where('status','=','A')
    			->orderBy('segment_code')
    			->lists('segment_code','item_segment_id');
    }
    
    /**
     * Get Customer Statuses
     */
    public function getCustomerStatus()
    {    	
    	$statusList = [
    			'A'=>'Active',
    			'D'=>'Deleted',
    			'I'=>'Inactive'    			
    	];    	
    	
    	return $statusList;
    }
    
    /**
     * Get Condition Codes
     */
    public function getConditionCodes()
    {
    	$codes = [
    		'GOOD' => 'GOOD',
    		'BAD' => 'BAD'	
    		/* ['id'=>'GOOD','text'=>'GOOD'],
    		['id'=>'BAD','text'=>'BAD'], */
    	];
    	return response()->json($codes);
    }
    
    /**
     * Export report to xls or pdf
     * @param unknown $type
     * @param unknown $report
     */
    public function exportReport($type, $report, $offset=0)
    {    	
    	if(!in_array($type, $this->validExportTypes))
    	{
    		return;
    	}
    	
    	$records = [];
    	$columns = [];
    	$rows = [];
    	$summary = [];
    	$header = '';
    	$filters = [];
    	$filename = 'Report';
    	$prepare = '';
    	$vaninventory = false;
    	
    	
    	$limit = in_array($type,['xls','xlsx']) ? config('system.report_limit_xls') : config('system.report_limit_pdf');
    	$offset = ($offset == 1) ? 0 : $offset;
    	
    	switch($report)
    	{
    		case 'salescollectionreport':
    			return $this->getSalesCollectionReport();
    		case 'salescollectionposting':
    			return $this->getSalesCollectionPosting();
    		case 'salescollectionsummary':
    			return $this->getSalesCollectionSummary();
    		case 'unpaidinvoice';
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedUnpaidInvoice();
    			$rows = $this->getUnpaidSelectColumns();
    			$summary = $this->getPreparedUnpaidInvoice(true)->first();
    			$header = 'Unpaid Invoice Report';
    			$filters = $this->getUnpaidFilterData();
    			$filename = 'Unpaid Invoice Report';
    			break;
    		case 'vaninventorycanned';
    			$vaninventory = true; 				
    			$status = $this->request->get('status') ? $this->request->get('status') : 'A';
    			$columns = $this->getVanInventoryColumns('canned',$status);
    			
    			$params = $this->request->all();
    			$from = date('Y/m/d', strtotime($params['transaction_date_from']));
    			$to = $params['transaction_date_to'];
    			while(strtotime($from) <= strtotime($to))
    			{
    				$params['transaction_date'] = $from;
    				$this->request->replace($params);
    				$from = date('Y/m/d', strtotime('+1 day', strtotime($from)));
    				$records = array_merge($records,$this->getVanInventory(true, $offset));
    			}
    			    			
	    		$rows = $this->getVanInventorySelectColumns('canned',$status);
	    		$header = 'Van Inventory and History Report';
	    		$filters = $this->getVanInventoryFilterData();
	    		$filename = 'Van Inventory and History Report(Canned & Mixes)';
	    		break;
    		case 'vaninventoryfrozen';
    			$vaninventory = true;
    			$status = $this->request->get('status') ? $this->request->get('status') : 'A';
    			$columns = $this->getVanInventoryColumns('frozen',$status);

    			$params = $this->request->all();
    			$from = date('Y/m/d', strtotime($params['transaction_date_from']));
    			$to = $params['transaction_date_to'];
    			while(strtotime($from) <= strtotime($to))
    			{
    				$params['transaction_date'] = $from;
    				$this->request->replace($params);
    				$from = date('Y/m/d', strtotime('+1 day', strtotime($from)));
    				$records = array_merge($records,$this->getVanInventory(true, $offset));
    			}
    			
	    		$rows = $this->getVanInventorySelectColumns('frozen',$status);
	    		$header = 'Van Inventory and History Report';
	    		$filters = $this->getVanInventoryFilterData();
    			$filename = 'Van Inventory and History Report(Frozen & Kassel)';
    			break;    			
    		case 'bir':
    			return $this->getBir();
    		case 'salesreportpermaterial';
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedSalesReportMaterial();
    			$rows = $this->getSalesReportMaterialSelectColumns();
    			$summary = $this->getPreparedSalesReportMaterial(true)->first();
    			$header = 'Sales Report Per Material';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Sales Report Per Material';
    			break;
    		case 'salesreportperpeso':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedSalesReportPeso();
    			$rows = $this->getSalesReportPesoSelectColumns();
    			$summary = $this->getPreparedSalesReportPeso(true)->first();
    			$header = 'Sales Report Per Peso';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Sales Report Per Peso';
    			break;
    		case 'returnpermaterial':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedReturnMaterial();
    			$rows = $this->getReturnReportMaterialSelectColumns();
    			$summary = $this->getPreparedReturnMaterial(true)->first();
    			$header = 'Return Per Material';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Return Per Material';
    			break;
    		case 'returnperpeso':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedReturnPeso();
    			$rows = $this->getReturnReportPesoSelectColumns();
    			$summary = $this->getPreparedReturnPeso(true)->first();
    			$header = 'Return Per Peso';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Return Per Peso';
    			break;
    		case 'customerlist':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedCustomerList();
    			$rows = $this->getCustomerSelectColumns();
    			$header = 'Customer List';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Customer List';
    			break;
    		case 'salesmanlist':
    			$columns = $this->getTableColumns($report);    			
    			$prepare = $this->getPreparedSalesmanList();
    			$rows = $this->getSalesmanSelectColumns();
    			$header = 'Salesman List';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Salesman List';
    			break;
    		case 'materialpricelist':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedMaterialPriceList();
    			$rows = $this->getMaterialPriceSelectColumns();
    			$header = 'Material Price List';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Material Price List';
    			break;
    		default:
    			return;
    	}	
    	
    	if(!$vaninventory)
    	{
	    	$prepare = $prepare->skip($offset)->take($limit);
	    	$records = $prepare->get();
    	}
    	//dd($rows);
    	//dd($records);
    	/* $this->view->columns = $columns;    	    
    	$this->view->rows = $rows;
    	$this->view->header = $header;
    	$this->view->filters = $filters;
    	$this->view->records = $records; 
    	$this->view->summary = $summary;
    	return $this->view('exportXls'); */
    	if(in_array($type,['xls','xlsx']))
    	{    
	    	\Excel::create($filename, function($excel) use ($columns,$rows,$records,$summary,$header,$filters){
	    		$excel->sheet('Sheet1', function($sheet) use ($columns,$rows,$records,$summary,$header,$filters){
	    			$params['columns'] = $columns;
	    			$params['rows'] = $rows;
	    			$params['records'] = $records;
	    			$params['summary'] = $summary;
	    			$params['header'] = $header;
	    			$params['filters'] = $filters;
	    			$sheet->loadView('Reports.exportXls', $params);
	    		});
	    	
	    	})->export($type);
    	}
    	elseif($type == 'pdf')
    	{
    		\Excel::create($filename, function($excel) use ($columns,$rows,$records){
    			$excel->sheet('Sheet1', function($sheet) use ($columns,$rows,$records){
    				$params['columns'] = $columns;
    				$params['rows'] = $rows;
    				$params['records'] = $records;
    				$sheet->loadView('Reports.exportPdf', $params);
    			});
    		
    		})->export($type);
    	}
    }
    
    /**
     * Return sales material select columns
     * @return multitype:string
     */
    public function getSalesReportMaterialSelectColumns()
    {
    	return [
    		'so_number',
    		'reference_num',
    		'activity_code',
    		'customer_code',
    		'customer_name',
    		'remarks',
    		'van_code',
    		'device_code',
    		'salesman_code',
    		'salesman_name',
    		'area',
    		'invoice_number',
    		'invoice_date',    						
    		'invoice_posting_date',
    		'segment_code',
    		'item_code',
    		'description',
    		'quantity',
    		'condition_code',
    		'uom_code',
    		'gross_served_amount',
    		'vat_amount',    					
    		'discount_rate',
    		'discount_amount',
    		'collective_discount_rate',
    		'collective_discount_amount',
    		'discount_reference_num',
    		'discount_remarks',
    		'collective_deduction_rate',
    		'collective_deduction_amount',
    		'deduction_reference_num',
    		'deduction_remarks',
    		'total_invoice',    					
    	]; 
    }
    
    /**
     * Return van inventory select columns
     * @return multitype:string
     */
    public function getVanInventorySelectColumns($type, $status='A')
    {
    	$columns = [
    			'customer_name',
    			'invoice_date',
    			'invoice_number',
    			'return_slip_num',
    			'transaction_date',
    			'stock_transfer_number',
    			'replenishment_date',
    			'replenishment_number',    			
    	];
    	
    	$items = $this->getVanInventoryItems($type,'item_code',$status);
    	foreach($items as $item)
    	{
    		$columns[] = 'code_'.$item->item_code;
    	}
    	
    	return $columns;
    }
    
    
    /**
     * Get return  material select columns
     * @return multitype:string
     */
    public function getReturnReportMaterialSelectColumns()
    {
    	return [
    			'return_txn_number',
    			'reference_num',
    			'activity_code',
    			'customer_code',
    			'customer_name',
    			'remarks',
    			'van_code',
    			'device_code',
    			'salesman_code',
    			'salesman_name',
    			'area',
    			'return_slip_num',
    			'return_date',
    			'return_posting_date',
    			'segment_code',
    			'item_code',
    			'description',
    			'condition_code',
    			'quantity',    			 
    			'uom_code',    			
    			'gross_amount',
    			'vat_amount',
    			'discount_rate',
    			'discount_amount',
    			'collective_discount_rate',
    			'collective_discount_amount',
    			'discount_reference_num',
    			'discount_remarks',
    			'total_invoice',
    	];
    }
    
    /**
     * Get return  peso select columns
     * @return multitype:string
     */
    public function getReturnReportPesoSelectColumns()
    {
    	return [
    			'return_txn_number',
    			'reference_num',
    			'activity_code',
    			'customer_code',
    			'customer_name',
    			'remarks',
    			'van_code',
    			'device_code',
    			'salesman_code',
    			'salesman_name',
    			'area',
    			'return_slip_num',
    			'return_date',
    			'return_posting_date',
    			'gross_amount',
    			'vat_amount',
    			'discount_rate',
    			'discount_amount',
    			'collective_discount_rate',
    			'collective_discount_amount',
    			'discount_reference_num',
    			'discount_remarks',
    			'total_invoice',
    	];
    }
    
    /**
     * Return sales material select columns
     * @return multitype:string
     */
    public function getSalesReportPesoSelectColumns()
    {
    	return [
    			'so_number',
    			'reference_num',
    			'activity_code',
    			'customer_code',
    			'customer_name',
    			'remarks',
    			'van_code',
    			'device_code',
    			'salesman_code',
    			'salesman_name',
    			'area',
    			'invoice_number',
    			'invoice_date',
    			'invoice_posting_date',    			
    			'gross_served_amount',
    			'vat_amount',
    			'discount_rate',
    			'discount_amount',
    			'collective_discount_rate',
    			'collective_discount_amount',
    			'discount_reference_num',
    			'discount_remarks',
    			'collective_deduction_rate',
    			'collective_deduction_amount',
    			'deduction_reference_num',
    			'deduction_remarks',
    			'total_invoice',
    	];
    }
    
    
    /**
     * Return customer list select columns
     * @return multitype:string
     */
    public function getCustomerSelectColumns()
    {
    	return [
    			'customer_code',
    			'customer_name',
    			'address',
    			'area_code',
    			'area_name',
    			'storetype_code',
    			'storetype_name',
    			'vatposting_code',
    			'vat_ex_flag',
    			'customer_price_group',
    			'salesman_code',
    			'salesman_name',
    			'van_code',
    			'sfa_modified_date',
    			'status',
    	];
    }
    
    
    /**
     * Return salesman list select columns
     * @return multitype:string
     */
    public function getSalesmanSelectColumns()
    {
    	return [
    			'salesman_code',
    			'salesman_name',    			 
    			'area_code',
    			'area_name',
    			'van_code',
    			'sfa_modified_date',
    			'status',
    	];
    }
    
    
    /**
     * Return Unpaid Select Columns
     * @return multitype:string
     */
    public function getUnpaidSelectColumns()
    {
    	return [
    			'salesman_name',
			    'area_name',
			    'customer_code',
			    'customer_name',
			    'remarks',
			    'invoice_number',
			    'invoice_date',
			    'original_amount',
			    'balance_amount'
    	];
    }
    
    
    /**
     * Return material price list select columns
     * @return multitype:string
     */
    public function getMaterialPriceSelectColumns()
    {
    	return [
    			'item_code',
    			'item_description',
    			'uom_code',
    			'segment_code',
    			'unit_price',
    			'customer_price_group',
    			'effective_date_from',
    			'effective_date_to',
    			'area_name',
    			'sfa_modified_date',
    			'status',
    	];
    }
    
    
    /**
     * Get report data count
     * @param string $report
     * @return JSON the data count
     */
    public function getDataCount($report, $type='xls')
    {
    	$data = [];
    	$prepare = '';
    	switch($report)
    	{
    		case 'unpaidinvoice';
    			$prepare = $this->getPreparedUnpaidInvoice();
    		case 'vaninventorycanned':
    		case 'vaninventoryfrozen':
    			$prepare = $this->getPreparedVanInventory();    			
    		case 'salesreportpermaterial':
    			$prepare = $this->getPreparedSalesReportMaterial();
    			break;
    		case 'salesreportperpeso':
    			$prepare = $this->getPreparedSalesReportPeso();
    			break;
    		case 'returnpermaterial':
    			$prepare = $this->getPreparedReturnMaterial();
    			break;
    		case 'returnperpeso':
    			$prepare = $this->getPreparedReturnPeso();
    			break;
    		case 'customerlist':
    			$prepare = $this->getPreparedCustomerList();
    			break;
    		case 'salesmanlist':
    			$prepare = $this->getPreparedSalesmanList();
    			break;
    		case 'materialpricelist':
    			$prepare = $this->getPreparedMaterialPriceList();
    			break;
    		default:
    			return;
    	}
    	
    	$total = $prepare->getCountForPagination();
    	if(in_array($type,['xls','xlsx']))
    		$limit = config('system.report_limit_xls');
    	else
    		$limit = config('system.report_limit_pdf');
    	$data['total'] = $total;
    	$data['limit'] = $limit;
    	if($total > $limit)
    	{
    		$data['max_limit'] = true;
    		$counter = 0;
    		$staggered = [];
    		for($i=0;$i < floor($total/$limit);$i++)
    		{
    			$from = $counter + 1;
    			$to = $counter + $limit;
    			$staggered[]  = ['from'=>$from,'to'=>$to];
    			$counter = $to;
    		}
    		if($counter < $total)
    		{
    			$staggered[] = ['from'=>$counter+1,'to'=>$counter+($total-$counter)];
    		}
    		$data['staggered'] = $staggered;
    	}
    	else 
    	{
    		$data['max_limit'] = false;
    		$data['staggered'] = [];
    	}
    	
    	return response()->json($data);
    }
    
    /**
     * Get Sales Report Filter data
     * @param string $report
     * @return Ambigous <multitype:, multitype:string \App\Http\Presenters\multitype: Ambigous <string, \App\Http\Presenters\multitype:> >
     */
    public function getSalesReportFilterData($report='salesreportpermaterial')
    {
    	$filters = [];
    	switch($report)
    	{
    		case 'salesreportpermaterial':
    			$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    			$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    			$customer = $this->request->get('customer') ? $this->getCustomer()[$this->request->get('customer')] : 'All';
    			$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    			$material = $this->request->get('material') ? $this->getItems()[$this->request->get('material')] : 'All';
    			$segment = $this->request->get('segment') ? $this->getItemSegmentCode()[$this->request->get('segment')] : 'All';
    			$returnDate = ($this->request->get('return_date_from') && $this->request->get('return_date_to')) ? $this->request->get('return_date_from').' - '.$this->request->get('return_date_to') : 'All';
    			$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    			$invoiceNum = $this->request->get('invoice_number');
    			 
    			$filters = [
    					'Salesman' => $salesman,
    					'Area' => $area,
    					'Customer' => $customer,
    					'Company Code' => $company_code,
    					'Material' => $material,
    					'Segment' => $segment,
    					'Invoice Date/Return Date' => $returnDate,
    					'Posting Date' => $postingDate,
    					'Invoice Number' => $invoiceNum
    			];
    			break;
    		case 'salesreportperpeso':
    			$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    			$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    			$customer = $this->request->get('customer') ? $this->getCustomer()[$this->request->get('customer')] : 'All';
    			$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    			$returnDate = ($this->request->get('return_date_from') && $this->request->get('return_date_to')) ? $this->request->get('return_date_from').' - '.$this->request->get('return_date_to') : 'All';
    			$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    			$invoiceNum = $this->request->get('invoice_number');
    			
    			$filters = [    					
    				'Salesman' => $salesman,
    				'Area' => $area,
    				'Customer' => $customer,
    				'Company Code' => $company_code,
    				'Invoice Date/Return Date' => $returnDate,
    				'Posting Date' => $postingDate,
    				'Invoice Number' => $invoiceNum
    			];    			    			
    			break;
    		case 'returnpermaterial':
    			$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    			$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    			$customer = $this->request->get('customer') ? $this->getCustomer()[$this->request->get('customer')] : 'All';
    			$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    			$material = $this->request->get('material') ? $this->getItems()[$this->request->get('material')] : 'All';
    			$segment = $this->request->get('segment') ? $this->getItemSegmentCode()[$this->request->get('segment')] : 'All';
    			$returnDate = ($this->request->get('return_date_from') && $this->request->get('return_date_to')) ? $this->request->get('return_date_from').' - '.$this->request->get('return_date_to') : 'All';
    			$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    			$invoiceNum = $this->request->get('invoice_number');
    			 
    			$filters = [
    					'Salesman' => $salesman,
    					'Area' => $area,
    					'Customer' => $customer,
    					'Company Code' => $company_code,
    					'Material' => $material,
    					'Segment' => $segment,
    					'Invoice Date/Return Date' => $returnDate,
    					'Posting Date' => $postingDate,
    					'Invoice Number' => $invoiceNum
    			];		
    			break;
    		case 'returnperpeso':
    				$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    				$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    				$customer = $this->request->get('customer') ? $this->getCustomer()[$this->request->get('customer')] : 'All';
    				$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    				$returnDate = ($this->request->get('return_date_from') && $this->request->get('return_date_to')) ? $this->request->get('return_date_from').' - '.$this->request->get('return_date_to') : 'All';
    				$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    				$invoiceNum = $this->request->get('invoice_number');
    				
    				$filters = [
    						'Salesman' => $salesman,
    						'Area' => $area,
    						'Customer' => $customer,
    						'Company Code' => $company_code,
    						'Invoice Date/Return Date' => $returnDate,
    						'Posting Date' => $postingDate,
    						'Invoice Number' => $invoiceNum
    				];
    				break;
    		 case 'customerlist':
    				$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    				$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    				$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    				$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    				$sfa_modified_date = $this->request->get('sfa_modified_date') ? $this->request->get('sfa_modified_date') : 'All';
    					 
    				$filters = [
    							'Salesman' => $salesman,
    							'Area' => $area,
    							'Company' => $company_code,
    							'Status' => $status,
    							'Sfa Modified Date' => $sfa_modified_date,
    				];
    				break;
    		 case 'salesmanlist':
    				$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    				$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    				$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    				$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    				$sfa_modified_date = $this->request->get('sfa_modified_date') ? $this->request->get('sfa_modified_date') : 'All';
    				
    				$filters = [
    							'Salesman' => $salesman,
    							'Area' => $area,
    							'Company' => $company_code,
    							'Status' => $status,
    							'Sfa Modified Date' => $sfa_modified_date,
    				];
    				break;
    		  case 'materialpricelist':
	    		  	$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
	    			$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
	    			$material = $this->request->get('material') ? $this->getItems()[$this->request->get('material')] : 'All';
	    			$segment = $this->request->get('segment') ? $this->getItemSegmentCode()[$this->request->get('segment')] : 'All';
	    			$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    				$sfa_modified_date = $this->request->get('sfa_modified_date') ? $this->request->get('sfa_modified_date') : 'All';
	    			 
	    			$filters = [
	    					'Company Code' => $company_code,	    					
	    					'Area' => $area,
	    					'Material' => $material,
	    					'Segment' => $segment,
	    					'Status' => $status,
	    					'Sfa Modified Date' => $sfa_modified_date,
	    					
	    			];
    				break;
    	}
    	
    	return $filters;
    }
    
    /**
     * Get Van inventory filters
     */
    public function getVanInventoryFilterData()
    {
    	$filters = [];
    	 
    	$salesman = $this->request->get('salesman_code') ? $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    	
    	$invoiceNum = $this->request->get('invoice_number');
    	$stockTransNum = $this->request->get('stock_transfer_number');
    	$returnSlipNum = $this->request->get('return_slip_num');
    	$referenceNum = $this->request->get('reference_number');
    	
    	$transDate = ($this->request->get('transaction_date_from') && $this->request->get('transaction_date_to')) ? $this->request->get('transaction_date_from').' - '.$this->request->get('transaction_date_to') : 'None';
    	
    	$filters = [
    			'Salesman' => $salesman,
    			'Status' => $status,
    			'Invoice #' => $invoiceNum,
    			'Stock Transfer #' => $stockTransNum,
    			'Return Slip #' => $returnSlipNum,
    			'Reference #' => $referenceNum,
    			'Transaction Date' => $transDate,    			
    	];
    	
    	return $filters;
    }
    
    
    /**
     * Get Van inventory filters
     */
    public function getUnpaidFilterData()
    {
    	$filters = [];
    
    	$salesman = $this->request->get('salesman') ? $this->getSalesman()[$this->request->get('salesman')] : 'All';
    	$company = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    	$customer = $this->request->get('customer') ? $this->getCustomer()[$this->request->get('customer')] : 'All';
    	$invoiceDate = ($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to')) ? $this->request->get('invoice_date_from').' - '.$this->request->get('invoice_date_to') : 'All';
    	 
    	$filters = [
    			'Salesman' => $salesman,
    			'Company' => $company,
    			'Customer' => $customer,
    			'Invoice Date' => $invoiceDate,
    	];
    	 
    	return $filters;
    }
}
