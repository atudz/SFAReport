<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;

class SalesCollectionPresenter extends PresenterCore
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function cashpayments()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->companyCode = $reportsPresenter->getCompanyCode();
    	$this->view->customerCode = $reportsPresenter->getCustomerCode();
    	$this->view->salesman = $reportsPresenter->getSalesman();
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->customers = $reportsPresenter->getCustomer();
    	$this->view->tableHeaders = $this->getCashPaymentColumns();
    	return $this->view('cashpayments');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function checkpayments()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->companyCode = $reportsPresenter->getCompanyCode();
    	$this->view->customerCode = $reportsPresenter->getCustomerCode();
    	$this->view->salesman = $reportsPresenter->getSalesman();
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->customers = $reportsPresenter->getCustomer();
    	$this->view->tableHeaders = $this->getCheckPaymentColumns();
    	return $this->view('checkPayments');
    }
    
    /**
     * Get cash payments report
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCashPaymentReport()
    {
    	$prepare = $this->getPreparedCashPayment();
    	$collection = PresenterFactory::getInstance('DeleteRemarks')->setDeleteRemarksTable($prepare->get(),'txn_sales_order_header');
    	
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$result = $reportsPresenter->formatSalesCollection($collection);
    	
    	$summary = '';
    	if($result)
    	{
    		$summary = $this->getCashPaymentTotal($result);
    	}  
    	$data['records'] = $reportsPresenter->validateInvoiceNumber($result);
    	 
    	$data['summary'] = '';
    	if($summary)
    	{
    		$data['summary'] = $summary;
    	}
    	
    	$data['total'] = count($result);
    	
    	return response()->json($data);
    }
    
    /**
     * Get check payments report
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCheckPaymentReport()
    {
    	$prepare = $this->getPreparedCheckPayment();
    	$collection = PresenterFactory::getInstance('DeleteRemarks')->setDeleteRemarksTable($prepare->get(),'txn_sales_order_header');    	
    
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$result = $reportsPresenter->formatSalesCollection($collection);
    
    	$summary = '';
    	if($result)
    	{
    		$summary = $this->getCashPaymentTotal($result);
    	}
    	$data['records'] = $reportsPresenter->validateInvoiceNumber($result);

    	$data['summary'] = '';
    	if($summary)
    	{
    		$data['summary'] = $summary;
    	}
    
    	$data['total'] = count($result);
    
    	return response()->json($data);
    }
    
    /**
     * Get cash payment total
     * @param unknown $data
     * @return multitype:string unknown
     */
    public function getCashPaymentTotal($data)
    {
    	$summary = [
    			'payment_amount'=>0,
    			'total_invoice_net_amount'=>0,
    	];
    	 
    	$cols = array_keys($summary);
    	foreach($data as $val)
    	{
    		foreach($cols as $key)
    			$summary[$key] += $val->$key;
    	}
    	
    	return $summary;
    }
    /**
     * Get preapred statement for cash payment
     * @param string $summary
     * @return unknown
     */
    public function getPreparedCashPayment($summary=false)
    {
    	$query = ' 
    			  SELECT
    			   sotbl.so_number,
    			   tas.salesman_code,
    			   tas.customer_code,    			   
				   CONCAT(ac.customer_name,ac.customer_name2) customer_name,
	    		   IF(ac.address_1=\'\',
	    				IF(ac.address_2=\'\',ac.address_3,
	    					IF(ac.address_3=\'\',ac.address_2,CONCAT(ac.address_2,\', \',ac.address_3))
	    					),
	    				IF(ac.address_2=\'\',
	    					IF(ac.address_3=\'\',ac.address_1,CONCAT(ac.address_1,\', \',ac.address_3)),
	    					  IF(ac.address_3=\'\',
	    							CONCAT(ac.address_1,\', \',ac.address_2),
	    							CONCAT(ac.address_1,\', \',ac.address_2,\', \',ac.address_3)
	    						)
	    					)
	    			) customer_address,
				   remarks.remarks,    			   
				   sotbl.invoice_number,
				   sotbl.delete_remarks,
				   sotbl.sales_order_header_id delete_remarks_id,
				   sotbl.so_date invoice_date,
				   (coalesce((coalesce(sotbl.so_total_served,0) - coalesce(sotbl.so_total_item_discount,0) - coalesce(sotbl.so_total_collective_discount,0.00)),0.00) - coalesce(sotbl.so_total_ewt_deduction, 0.00) - coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00)) total_invoice_net_amount,
    			
				   coltbl.or_date,
	               UPPER(coltbl.or_number) or_number,
				   coltbl.payment_amount,
				   (IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0)) total_collected_amount,
    			
    			   coltbl.collection_detail_id,
    			   IF(sotbl.updated=\'modified\',sotbl.updated,IF(rtntbl.updated=\'modified\',rtntbl.updated,IF(coltbl.updated=\'modified\',coltbl.updated,IF(tsohd2.updated_by,\'modified\',\'\')))) updated				
    	
				   from txn_activity_salesman tas
				   left join app_customer ac on ac.customer_code=tas.customer_code
				   join
					-- SALES ORDER SUBTABLE
					(
						select
    						all_so.sales_order_header_id,
    			
							all_so.so_number,
							all_so.reference_num,
							all_so.salesman_code,
							all_so.customer_code,
							all_so.so_date,
							all_so.invoice_number,
							all_so.delete_remarks,
    						all_so.sfa_modified_date,
							sum(all_so.total_served) as so_total_served,
							sum(all_so.total_discount) as so_total_item_discount,
						
							(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as so_total_ewt_deduction,
							(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as so_total_collective_discount,			
    			
    						all_so.updated
						from (
								select
    								tsoh.sales_order_header_id,
									tsoh.so_number,
									tsoh.reference_num,
									tsoh.salesman_code,
									tsoh.customer_code,
									tsoh.so_date,
    								tsoh.sfa_modified_date,
									tsoh.invoice_number,
                                    tsoh.delete_remarks,
									sum(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00)) as total_served,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as total_vat,
									sum(coalesce(tsod.discount_amount,0.00)) as total_discount,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as so_amount,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as net_amount,
    								IF(tsoh.updated_by,\'modified\',IF(tsod.updated_by,\'modified\',\'\')) updated
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
    								tsoh.sales_order_header_id,
									tsoh.so_number,
									tsoh.reference_num,
									tsoh.salesman_code,
									tsoh.customer_code,
									tsoh.so_date,
    								tsoh.sfa_modified_date,
									tsoh.invoice_number,
									tsoh.delete_remarks,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as total_served,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as total_vat,
									0.00 as total_discount,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as so_amount,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as net_amount,
    								IF(tsoh.updated_by,\'modified\',IF(tsodeal.updated_by,\'modified\',\'\')) updated
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
			
						
						left join txn_sales_order_header_discount tsohd on all_so.reference_num = tsohd.reference_num
						
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
    						trh.return_header_id,
							trh.return_txn_number,
							trh.reference_num,
							trh.salesman_code,
							trh.customer_code,
							sum(coalesce(trd.gross_amount,0.00) + coalesce(trd.vat_amount,0.00)) as RTN_total_gross,
							coalesce(trhd.collective_discount_amount,0.00) as RTN_total_collective_discount,
    						IF(trh.updated_by,\'modified\',IF(trd.updated_by,\'modified\',\'\')) updated
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
					join
					(
						select
							tch.reference_num,
							tch.salesman_code,
							tch.or_number,
							tch.or_date,
							tcd.payment_method_code,
							coalesce(tcd.payment_amount,0.00) payment_amount,
							tcd.cm_number,
    						tcd.collection_detail_id,
    						tci.invoice_number,
    						IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
			
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
						where tcd.payment_method_code=\'CASH\'
    					group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code,tcd.collection_detail_id
					) coltbl on coltbl.invoice_number = sotbl.invoice_number
			
					left join txn_invoice ti on coltbl.cm_number=ti.invoice_number and ti.document_type=\'CM\'
	    			left join
					(
						select evaluated_objective_id,remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
					) remarks ON(remarks.reference_num=tas.reference_num)
			
					WHERE  (tas.activity_code like \'%C%\' AND tas.activity_code not like \'%SO%\')
    					   OR (tas.activity_code like \'%SO%\')
    					   OR (tas.activity_code not like \'%C%\')
					ORDER BY tas.reference_num ASC,
					 		 tas.salesman_code ASC,
							 tas.customer_code ASC
    			';
    	
    	$select = '
    			collection.customer_code,
				collection.customer_name,
    			collection.customer_address,
				collection.remarks,
				collection.invoice_number,
                collection.remarks,
				collection.delete_remarks,
				collection.invoice_date,
				collection.total_invoice_net_amount,
				collection.or_date,
	            collection.or_number,
				collection.payment_amount,
				collection.total_collected_amount,
    			
    			collection.collection_detail_id,
				collection.updated,
                collection.delete_remarks_id

    	
    			';
    	 
    	if($summary)
    	{
    		$select = '    				    				
    				SUM(collection.total_invoice_net_amount) total_invoice_net_amount,    				
					SUM(collection.payment_amount) payment_amount
    				';
    	}
    	 
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))->selectRaw($select);
    	 
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    	 
    	$companyFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	 
    	$customerFilter = FilterFactory::getInstance('Text');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code',
    			function($self, $model){
    				return $model->where('collection.customer_code',$self->getValue());
    			});
    	
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    					function($self, $model){
    						return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    				});
    	
    	$orDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $orDateFilter->addFilter($prepare,'or_date',
    			function($self, $model){
    				return $model->whereBetween('collection.or_date',$self->formatValues($self->getValue()));
    			});
    	
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse %');
    		 
    	$prepare->orderBy('collection.invoice_number','asc');
    	$prepare->orderBy('collection.invoice_date','asc');
    	$prepare->orderBy('collection.customer_name','asc');
    	$prepare->orderBy('collection.so_number','asc');
    		 
    	return $prepare;
    }
    
    /**
     * Get cash payments
     * @return string[][]
     */
    public function getCashPaymentColumns($export='xls')
    {
    	$headers = [
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Customer Address','sort'=>'customer_address'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Invoice No','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Invoice Collectible Amount','sort'=>'total_invoice_net_amount'],
    			['name'=>'Collection Date','sort'=>'or_date'],
    			['name'=>'OR Number','sort'=>'or_number'],
    			['name'=>'Cash Amount'],
    			['name'=>'Text'],
    	];
    
    	if($export == 'pdf')
    		unset($headers[10]);
    		
    	return $headers;
    }
    
    
    /**
     * Get Cash Payment Select Columns
     * @return string[][]
     */
    function getCashPaymentSelectColumns($pdf=false)
    {
    	$columns = [
    			'customer_code',
    			'customer_name',
    			'customer_address',
    			'remarks',
    			'invoice_number',
    			'invoice_date',
    			'total_invoice_net_amount',
    			'or_date',
    			'or_number',
    			'payment_amount',
    			'delete_remarks'
    	];
    	
    	if($pdf)
    		unset($columns[10]);
    	
    	return $columns;
    }
    
    /**
     * get Cash Payment Filter Data
     * @return string[]|unknown[]
     */
    public function getCashPaymentFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$customer = $this->request->get('customer_code') ? $reportPresenter->getCustomer(false)[$this->request->get('customer_code')] : 'All';
    	$salesman = $this->request->get('salesman') ? $salesman = $reportPresenter->getSalesman()[$this->request->get('salesman')] : 'All';
    	$area = $this->request->get('area_code') ? $reportPresenter->getArea()[$this->request->get('area_code')] : 'All';
    	$company_code = $this->request->get('company_code') ? $reportPresenter->getCompanyCode()[$this->request->get('company_code')] : 'All';
    	$invoiceDate = ($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to')) ? $this->request->get('invoice_date_from').' - '.$this->request->get('invoice_date_to') : 'All';    	
    	$orDate = ($this->request->get('or_date_from') && $this->request->get('or_date_to')) ? $this->request->get('or_date_from').' - '.$this->request->get('or_date_to') : 'All';
    	
    	$filters = [
    			'Salesman' => $salesman,
    			'Area' => $area,
    			'Customer Name' => $customer,
    			'Company Code' => $company_code,
    			'Invoice Date' => $invoiceDate,
    			'Or Date' => $orDate,    			
    	];    	
    
    	return $filters;
    }
    
    
    /**
     * Get preapred statement for cash payment
     * @param string $summary
     * @return unknown
     */
    public function getPreparedCheckPayment($summary=false)
    {
    	$query = '
    			  SELECT
    			   sotbl.so_number,
    			   tas.salesman_code,
    			   tas.customer_code,
				   CONCAT(ac.customer_name,ac.customer_name2) customer_name,
	    		   IF(ac.address_1=\'\',
	    				IF(ac.address_2=\'\',ac.address_3,
	    					IF(ac.address_3=\'\',ac.address_2,CONCAT(ac.address_2,\', \',ac.address_3))
	    					),
	    				IF(ac.address_2=\'\',
	    					IF(ac.address_3=\'\',ac.address_1,CONCAT(ac.address_1,\', \',ac.address_3)),
	    					  IF(ac.address_3=\'\',
	    							CONCAT(ac.address_1,\', \',ac.address_2),
	    							CONCAT(ac.address_1,\', \',ac.address_2,\', \',ac.address_3)
	    						)
	    					)
	    			) customer_address,
				   remarks.remarks,
				   sotbl.invoice_number,
 				   sotbl.delete_remarks,
				   sotbl.sales_order_header_id delete_remarks_id,
				   sotbl.so_date invoice_date,
				   (coalesce((coalesce(sotbl.so_total_served,0) - coalesce(sotbl.so_total_item_discount,0) - coalesce(sotbl.so_total_collective_discount,0.00)),0.00) - coalesce(sotbl.so_total_ewt_deduction, 0.00) - coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00)) total_invoice_net_amount,
    
				   coltbl.or_date,
	               UPPER(coltbl.or_number) or_number,
				   coltbl.payment_amount,
    
    			   IF(coltbl.payment_method_code=\'CASH\',\'\', ti.invoice_date) cm_date,
    			   coltbl.bank,
				   coltbl.check_number,
				   IF(coltbl.payment_method_code=\'CASH\',\'\', coltbl.check_date) check_date,
				
    			   coltbl.collection_detail_id,
    			   IF(sotbl.updated=\'modified\',sotbl.updated,IF(rtntbl.updated=\'modified\',rtntbl.updated,IF(coltbl.updated=\'modified\',coltbl.updated,IF(tsohd2.updated_by,\'modified\',\'\')))) updated
  
				   from txn_activity_salesman tas
				   left join app_customer ac on ac.customer_code=tas.customer_code
				   join
					-- SALES ORDER SUBTABLE
					(
						select
    						all_so.sales_order_header_id,
    
							all_so.so_number,
							all_so.reference_num,
							all_so.salesman_code,
							all_so.customer_code,
							all_so.so_date,
							all_so.invoice_number,
                            all_so.delete_remarks,
    						all_so.sfa_modified_date,
							sum(all_so.total_served) as so_total_served,
							sum(all_so.total_discount) as so_total_item_discount,
    
							(case when deduction_code = \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as so_total_ewt_deduction,
							(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as so_total_collective_discount,
    
    						all_so.updated
						from (
								select
    								tsoh.sales_order_header_id,
									tsoh.so_number,
									tsoh.reference_num,
									tsoh.salesman_code,
									tsoh.customer_code,
									tsoh.so_date,
    								tsoh.sfa_modified_date,
									tsoh.invoice_number,
                                    tsoh.delete_remarks,
									sum(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00)) as total_served,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as total_vat,
									sum(coalesce(tsod.discount_amount,0.00)) as total_discount,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as so_amount,
									sum(coalesce(coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as net_amount,
    								IF(tsoh.updated_by,\'modified\',IF(tsod.updated_by,\'modified\',\'\')) updated
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
    								tsoh.sales_order_header_id,
									tsoh.so_number,
									tsoh.reference_num,
									tsoh.salesman_code,
									tsoh.customer_code,
									tsoh.so_date,
    								tsoh.sfa_modified_date,
									tsoh.invoice_number,
                                    tsoh.delete_remarks,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as total_served,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as total_vat,
									0.00 as total_discount,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as so_amount,
									sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as net_amount,
    								IF(tsoh.updated_by,\'modified\',IF(tsodeal.updated_by,\'modified\',\'\')) updated
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
    
    
						left join txn_sales_order_header_discount tsohd on all_so.reference_num = tsohd.reference_num						
  
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
    						trh.return_header_id,
							trh.return_txn_number,
							trh.reference_num,
							trh.salesman_code,
							trh.customer_code,
							sum(coalesce(trd.gross_amount,0.00) + coalesce(trd.vat_amount,0.00)) as RTN_total_gross,
							coalesce(trhd.collective_discount_amount,0.00) as RTN_total_collective_discount,
    						IF(trh.updated_by,\'modified\',IF(trd.updated_by,\'modified\',\'\')) updated
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
					join
					(
						select
							tch.reference_num,
							tch.salesman_code,
							tch.or_number,
							tch.or_date,
							tcd.payment_method_code,
							coalesce(tcd.payment_amount,0.00) payment_amount,
    						tcd.check_number,
							tcd.check_date,
							tcd.bank,
							tcd.cm_number,
    						tcd.collection_detail_id,
    						tci.invoice_number,
    						IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
    
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
    					where tcd.payment_method_code=\'CHECK\'
    					group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code,tcd.collection_detail_id
					) coltbl on coltbl.invoice_number = sotbl.invoice_number
    
					left join txn_invoice ti on coltbl.cm_number=ti.invoice_number and ti.document_type=\'CM\'
	    			left join
					(
						select evaluated_objective_id,remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
					) remarks ON(remarks.reference_num=tas.reference_num)
    
					WHERE  (tas.activity_code like \'%C%\' AND tas.activity_code not like \'%SO%\')
    					   OR (tas.activity_code like \'%SO%\')
    					   OR (tas.activity_code not like \'%C%\')
					ORDER BY tas.reference_num ASC,
					 		 tas.salesman_code ASC,
							 tas.customer_code ASC
    			';
    
    	$select = '
    			collection.customer_code,
				collection.customer_name,
    			collection.customer_address,
				collection.remarks,
				collection.invoice_number,
				collection.delete_remarks,
				collection.invoice_date,
				collection.total_invoice_net_amount,
				collection.or_date,
	            collection.or_number,
				collection.payment_amount,
    			collection.cm_date,
    			collection.bank,
    			collection.check_number,
    			collection.check_date,
    			collection.collection_detail_id,
    			collection.updated,
                collection.delete_remarks_id
  
    			';
    
    	if($summary)
    	{
    		$select = '
					SUM(collection.total_invoice_net_amount) total_invoice_net_amount,
    				SUM(collection.payment_amount) payment_amount
    				';
    	}
    
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))->selectRaw($select);
    
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    
    	$companyFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    
    	$customerFilter = FilterFactory::getInstance('Text');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code',
    			function($self, $model){
    				return $model->where('collection.customer_code',$self->getValue());
    			});
    
    
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){
    				return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    			});
    
    	$orDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $orDateFilter->addFilter($prepare,'or_date',
    			function($self, $model){
    				return $model->whereBetween('collection.or_date',$self->formatValues($self->getValue()));
    			});
    
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse %');
    	 
    	if($sort = $this->request->get('sort'))
    	{
    		$prepare->orderBy('collection.'.$sort,$this->request->get('order'));
    	}
    	 
    	$prepare->orderBy('collection.invoice_number','asc');
    	$prepare->orderBy('collection.invoice_date','asc');
    	$prepare->orderBy('collection.customer_name','asc');
    	$prepare->orderBy('collection.so_number','asc');
    	 
    	 
    	return $prepare;
    }
    
    /**
     * Get cash payments
     * @return string[][]
     */
    public function getCheckPaymentColumns($export='xls')
    {
    	$headers = [
    			['name'=>'Customer Code','sort'=>'customer_code'],
    			['name'=>'Customer Name','sort'=>'customer_name'],
    			['name'=>'Customer Address','sort'=>'customer_address'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Invoice No','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Invoice Collectible Amount','sort'=>'total_invoice_net_amount'],
    			['name'=>'Collection Date','sort'=>'or_date'],
    			['name'=>'OR Number','sort'=>'or_number'],
    			['name'=>'Bank Name','sort'=>'bank'],
    			['name'=>'Check No','sort'=>'check_number'],
    			['name'=>'Check Date','sort'=>'check_date'],
    			['name'=>'Check Amount'],
    			['name'=>'Text'],
    	];
    	
    	if($export == 'pdf')
    		unset($headers[13]);
    
    	return $headers;
    }
    
    /**
     * Get Cash Payment Select Columns
     * @return string[][]
     */
    function getCheckPaymentSelectColumns($pdf=false)
    {
    	$columns = [
    			'customer_code',
    			'customer_name',
    			'customer_address',
    			'remarks',
    			'invoice_number',
    			'invoice_date',
    			'total_invoice_net_amount',
    			'or_date',
    			'or_number',    			    			
    			'bank',
    			'check_number',
    			'check_date',
    			'payment_amount',
    			'delete_remarks'
    	];
    	
    	if($pdf)
    		unset($columns[13]);
    	
    	return $columns;
    }
    
    /**
     * get Check Payment Filter Data
     * @return string[]|unknown[]
     */
    public function getCheckPaymentFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$customer = $this->request->get('customer_code') ? $reportPresenter->getCustomer(false)[$this->request->get('customer_code')] : 'All';
    	$salesman = $this->request->get('salesman') ? $salesman = $reportPresenter->getSalesman()[$this->request->get('salesman')] : 'All';
    	$area = $this->request->get('area_code') ? $reportPresenter->getArea()[$this->request->get('area_code')] : 'All';
    	$company_code = $this->request->get('company_code') ? $reportPresenter->getCompanyCode()[$this->request->get('company_code')] : 'All';
    	$invoiceDate = ($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to')) ? $this->request->get('invoice_date_from').' - '.$this->request->get('invoice_date_to') : 'All';
    	$orDate = ($this->request->get('or_date_from') && $this->request->get('or_date_to')) ? $this->request->get('or_date_from').' - '.$this->request->get('or_date_to') : 'All';
    
    	$filters = [
    			'Salesman' => $salesman,
    			'Area' => $area,
    			'Customer Name' => $customer,
    			'Company Code' => $company_code,
    			'Invoice Date' => $invoiceDate,
    			'Collection Date' => $orDate,
    	];
    
    	return $filters;
    }
    
}
