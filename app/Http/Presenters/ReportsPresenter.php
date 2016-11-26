<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Filters\SelectFilter;
use Illuminate\Database\Query\Builder;
use App\Factories\PresenterFactory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Factories\ModelFactory;
use Mockery\Exception;
use PHPExcel_Shared_Date;

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
    	$menus = \DB::table('navigation')->where('summary',1)->get();
    	$menuList = [];
    	foreach($menus as $menu)
    	{
    		$menuList[$menu->name] = $menu->active; 
    	}
    	$this->view->menuList = $menuList;    	
    	
    	$summary = \DB::table('report_summary')->get();
    	foreach($summary as $report)
    	{    	
    		$this->view->{$report->report} = $report->count;
    	}
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
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getSalesCollectionReportColumns();
    			return $this->view('salesCollectionReport');
    		case 'posting':
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->customerCode = $this->getCustomerCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->tableHeaders = $this->getSalesCollectionPostingColumns();
    			return $this->view('salesCollectionPosting');
    		case 'summary':
    			$this->view->customerCode = $this->getCompanyCode();
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
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('salesReportPerMaterial');
    		case 'perpeso':
    			$this->view->companyCode = $this->getCompanyCode();    			
    			$this->view->salesman = $this->getSalesman();
    			$this->view->customers = $this->getCustomer();    			 
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getSalesReportPesoColumns();
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('salesReportPerPeso');
    		case 'returnpermaterial':
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->items = $this->getItems();
    			$this->view->customers = $this->getCustomer();
    			$this->view->segments = $this->getItemSegmentCode();
    			$this->view->tableHeaders = $this->getReturnReportMaterialColumns();
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('returnsPerMaterial');
    		case 'returnperpeso':
    			$this->view->customers = $this->getCustomer();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->tableHeaders = $this->getReturnReportPerPesoColumns();
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('returnsPerPeso');
    		case 'customerlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->priceGroup = $this->getPriceGroup();
    			$this->view->tableHeaders = $this->getCustomerListColumns();
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('customerList');
    		case 'salesmanlist':
    			$this->view->salesman = $this->getSalesman();
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->tableHeaders = $this->getSalesmanListColumns();
    			$this->view->isSalesman = $this->isSalesman();
    			return $this->view('salesmanList');
    		case 'materialpricelist':
    			$this->view->segmentCodes = $this->getItemSegmentCode();
    			$this->view->items = $this->getItems(); 
    			$this->view->areas = $this->getArea();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->companyCode = $this->getCompanyCode();
    			$this->view->tableHeaders = $this->getMaterialPriceListColumns();
    			$this->view->isSalesman = $this->isSalesman();
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
				$this->view->auditor = $this->getAuditor();
    			$this->view->statuses = $this->getCustomerStatus();
    			$this->view->tableHeaders = $this->getVanInventoryColumns();
    			$this->view->itemCodes = $this->getVanInventoryItems('canned','item_code');
    			$this->view->type = 'canned';    			
    			return $this->view('vanInventory');
    		case 'frozen':
    			$this->view->title = 'Frozen & Kassel';
    			$this->view->auditor = $this->getAuditor();
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
    	$this->view->area = $this->getArea(false,false);
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
    	
    	$this->view->from = (new Carbon(config('system.go_live_date')))->subDay()->format('m/d/Y');
    	$this->view->to = (new Carbon())->format('m/d/Y');
    	$this->view->isSalesman = $this->isSalesman();
    	
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
            case 'usergrouplist':
                return PresenterFactory::getInstance('User')->getUserGroup();
			case 'summaryofincidentreport':
				return PresenterFactory::getInstance('User')->getSummaryOfIncidentReports();				
			case 'stocktransfer':
				return PresenterFactory::getInstance('VanInventory')->getStockTransferReport();
			case 'stockaudit':
				return PresenterFactory::getInstance('VanInventory')->getStockAuditReport();
			case 'flexideal':
				return PresenterFactory::getInstance('VanInventory')->getFlexiDealReport();
			case 'replenishment':
				return PresenterFactory::getInstance('VanInventory')->getReplenishmentReport();
			case 'adjustment':
				return PresenterFactory::getInstance('VanInventory')->getAdjustmentReport();
			case 'invoiceseries':
				return PresenterFactory::getInstance('Invoice')->getInvoiceSeriesReport();
    	}
    }
    
    
    /**
     * Get Sales Collection Summary 
     * @param unknown $data
     * @return multitype:string unknown
     */
    public function getSalesCollectionTotal($data)
    {    	
    	$summary = [
    		'so_total_served'=>0,
    		'so_total_item_discount'=>0,
    		'so_total_collective_discount'=>0,
    	    'total_invoice_amount'=>0,
    	    'RTN_total_gross'=>0,
    		'RTN_total_collective_discount'=>0,
    		'other_deduction_amount' => 0,
    		'RTN_net_amount'=>0,
            'total_invoice_net_amount'=>0,
    		'cash_amount'=>0,
    		'check_amount'=>0,
    		'credit_amount'=>0,
            'total_collected_amount'=>0
    	];
    	
    	$cols = array_keys($summary);
    	foreach($data as $val)
    	{
    		foreach($cols as $key)    		
    			$summary[$key] += $val->$key;
    	}
    	
    	//format
    	foreach($cols as $key)
    	{    			    			
    		$summary[$key] = number_format($summary[$key],2);
    	}
    	    	
    	return $summary;	
    }
    
    /**
     * Get Sales & Collection Report records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionReport()
    {
    	
    	$prepare = $this->getPreparedSalesCollection();
    	$collection1 = $prepare->get();
    
    	$referenceNum = [];
    	$invoiceNum = [];
    	foreach($collection1 as $col)
    	{
    		$referenceNum[] = $col->reference_num;
    		$invoiceNum[] = $col->invoice_number;
    	}
    	
    	array_unique($referenceNum);
    	array_unique($invoiceNum);
    	$except = $referenceNum ? ' AND tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\') ' : '';
    	$except .= $invoiceNum ? ' AND coltbl.invoice_number NOT IN(\''.implode("','",$invoiceNum).'\') ' : '';
    	
    	$prepare = $this->getPreparedSalesCollection2(false,$except);
    	$collection2 = $prepare->get();
    	
    	$collection = array_merge((array)$collection1,(array)$collection2);
    	$result = $this->formatSalesCollection($collection);
        
    	$summary1 = [];
    	if($result)
    	{
    		$summary1 = $this->getSalesCollectionTotal($result);    		
    	}

    	$data['records'] = $this->validateInvoiceNumber($result);
    	
    	$data['summary'] = '';
    	if($summary1)
    	{    		    	
    		$data['summary'] = $summary1;
    	}
    	 
    	
    	$data['total'] = count($result);
    	 
    	return response()->json($data);
    }
    
    /**
     * Format sales collection
     * @param unknown $data
     * @return unknown
     */
    public function formatSalesCollection($data)
    {

    	//dd($data);
    	$formatted = [];
    	$prevInvoiceNum = 0;
    	$customerCode = '';
    	$total = 0;
    	$index = 0;
    	$row = 1;
    	$max = count($data) - 1;
    	foreach($data as $k=>$rec)
    	{
    		if($prevInvoiceNum !== $rec->invoice_number || !$rec->invoice_number)
    		{
    			if($k)
    			{
    				$formatted[$index]->total_collected_amount = $total;
    				$formatted[$index]->rowspan = $row;
    				$formatted[$index]->show = $row > 1 || $row == 1 ? true : false;
    			}
    			
    			$prevInvoiceNum = $rec->invoice_number;
    			$customerCode = $rec->customer_code;
    			$row = 1;
    			$rec->rowspan = $row;
    			$rec->show = true;
    			$formatted[] = $rec;    			    			    			
    			$index = $k;  
    			$total = $rec->total_collected_amount;
    		}
    		else
    		{

    			$rec->customer_code = null;
    			$rec->customer_name = null;
    			$rec->remarks = null;
    			$rec->invoice_number = null;
    			$rec->invoice_date = null;
    			$rec->so_total_served = null;
    			$rec->so_total_item_discount = null;
    			$rec->so_total_collective_discount = null;
    			$rec->total_invoice_amount = null;
    			$rec->other_deduction_amount = null;
    			$rec->return_slip_num = null;
    			$rec->RTN_total_gross = null;
    			$rec->RTN_total_collective_discount = null;
    			$rec->RTN_net_amount = null;
    			$rec->total_invoice_net_amount = null;
    			$total += $rec->total_collected_amount;
    			$rec->total_collected_amount = null;
    			$rec->rowspan = 1;
    			$rec->show = false;
    			$row++;
    			$formatted[] = $rec;
    			
    			if($k == $max)
    			{
    				$formatted[$index]->total_collected_amount = $total;
    				$formatted[$index]->rowspan = $row;
    				$formatted[$index]->show = true;
    			}
    			 
    		}
    	}

    	return $formatted;
    }
    
    /**
     * Format sales collection
     * @param unknown $data
     * @return unknown
     */
    public function formatSalesCollection2($data)
    {
    	$formatted = [];
    	$prevInvoiceNum = 0;
    	$customerCode = '';
    	$total = 0;
    	$index = 0;
    	$row = 1;
    	$max = count($data) - 1;
    	foreach($data as $k=>$rec)
    	{
    		if($prevInvoiceNum !== $rec->or_number && $customerCode !== $rec->customer_code)
    		{
    			if($k)
    			{
    				$formatted[$index]->total_collected_amount = $total;
    				$formatted[$index]->rowspan = $row;
    				$formatted[$index]->show = $row > 1 || $row == 1 ? true : false;
    			}
    			 
    			$prevInvoiceNum = $rec->or_number;
    			$customerCode = $rec->customer_code;
    			$row = 1;
    			$rec->rowspan = $row;
    			$rec->show = true;
    			$formatted[] = $rec;
    			$index = $k;
    			$total = $rec->total_collected_amount;
    		}
    		else
    		{
    			 
    			$rec->customer_code = null;
    			$rec->customer_name = null;
    			$rec->remarks = null;
    			$rec->invoice_number = null;
    			$rec->invoice_date = null;
    			$rec->so_total_served = null;
    			$rec->so_total_item_discount = null;
    			$rec->so_total_collective_discount = null;
    			$rec->total_invoice_amount = null;
    			$rec->other_deduction_amount = null;
    			$rec->return_slip_num = null;
    			$rec->RTN_total_gross = null;
    			$rec->RTN_total_collective_discount = null;
    			$rec->RTN_net_amount = null;
    			$rec->total_invoice_net_amount = null;
    			$total += $rec->total_collected_amount;
    			$rec->total_collected_amount = null;
    			$rec->rowspan = 1;
    			$rec->show = false;
    			$row++;
    			$formatted[] = $rec;
    			 
    			if($k == $max)
    			{
    				$formatted[$index]->total_collected_amount = $total;
    				$formatted[$index]->rowspan = $row;
    				$formatted[$index]->show = true;
    			}
    
    		}
    	}

    	return $formatted;
    }
    
    /**
     * Return Prepared Sales Collection 
     * @return unknown
     */
    public function getPreparedSalesCollection($summary = false, $noInvoice=false)
    {
    	$query = ' SELECT
    			   sotbl.so_number,
    			   tas.reference_num,
    			   tas.salesman_code,
				   tas.customer_code,
    			   ac.area_code,
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
				   sotbl.so_date invoice_date,
				   coalesce(sotbl.so_total_served,0.00) so_total_served,
				   coalesce(sotbl.so_total_item_discount,0.00) so_total_item_discount,
				   coalesce(sotbl.so_total_collective_discount,0.00) so_total_collective_discount,
    			   sotbl.sfa_modified_date invoice_posting_date,
				   (coalesce(sotbl.so_total_served,0.00) - coalesce(sotbl.so_total_item_discount,0.00) - coalesce(sotbl.so_total_collective_discount,0.00)) total_invoice_amount,
    			   tsohd2.ref_no,		
			  	   coalesce(sotbl.so_total_ewt_deduction, 0.00) other_deduction_amount,	
				   rtntbl.return_slip_num,
				   coalesce(rtntbl.RTN_total_gross,0.00) RTN_total_gross,
				   coalesce(rtntbl.RTN_total_collective_discount,0.00) RTN_total_collective_discount,
				   coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00) RTN_net_amount,
				   (coalesce((coalesce(sotbl.so_total_served,0) - coalesce(sotbl.so_total_item_discount,0) - coalesce(sotbl.so_total_collective_discount,0.00)),0.00) - coalesce(sotbl.so_total_ewt_deduction, 0.00) - coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00)) total_invoice_net_amount,
    			
				   coltbl.or_date,
	               UPPER(coltbl.or_number) or_number,
				   IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, \'\') cash_amount,
				   IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, \'\') check_amount,
				   coltbl.bank,
				   coltbl.check_number,
				   IF(coltbl.payment_method_code=\'CASH\',\'\', coltbl.check_date) check_date,
				   coltbl.cm_number,
				   IF(coltbl.payment_method_code=\'CASH\',\'\', ti.invoice_date) cm_date,
			   	   IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0.00) credit_amount,
				   (IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0)) total_collected_amount,
    			
    			   remarks.evaluated_objective_id,
    			   sotbl.sales_order_header_id,
    			   coltbl.collection_header_id,
    			   coltbl.collection_detail_id,
    			   coltbl.collection_invoice_id,
    			   rtntbl.return_header_id,    			   
    			   IF(sotbl.updated=\'modified\',sotbl.updated,IF(rtntbl.updated=\'modified\',rtntbl.updated,IF(coltbl.updated=\'modified\',coltbl.updated,\'\'))) updated				
    	
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
    						all_so.sfa_modified_date,
							sum(all_so.total_served) as so_total_served,
							sum(all_so.total_discount) as so_total_item_discount,
						
							sum(tsohd.collective_discount_amount) as so_total_collective_discount,
							sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction,						
    			
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
    						trh.return_header_id,
							trh.return_txn_number,
							trh.reference_num,
							trh.salesman_code,
							trh.customer_code,
							trh.return_date,
							trh.return_slip_num,
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
					left join
					(
						select
							tch.reference_num,
							tch.salesman_code,
							tch.or_number,
							coalesce(tch.or_amount,0.00) or_amount,
							tch.or_date,
							tcd.payment_method_code,
							coalesce(tcd.payment_amount,0.00) payment_amount,
							tcd.check_number,
							tcd.check_date,
							tcd.bank,
							tcd.cm_number,
    						tch.collection_header_id,
    						tcd.collection_detail_id,
    						tci.collection_invoice_id,
    						tci.invoice_number,
    						IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
			
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
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
    			collection.so_number,
    			collection.reference_num,
    			collection.customer_code,
				collection.customer_name,
    			collection.customer_address,
				collection.remarks,
				collection.invoice_number,
				collection.invoice_date,
				collection.so_total_served,
				collection.so_total_item_discount,
				collection.so_total_collective_discount,
				collection.total_invoice_amount,
    			collection.ref_no,
				collection.other_deduction_amount,
				collection.return_slip_num,
				collection.RTN_total_gross,
				collection.RTN_total_collective_discount,
				collection.RTN_net_amount,
				collection.total_invoice_net_amount,
				collection.or_date,
	            collection.or_number,
				collection.cash_amount,
				collection.check_amount,
				collection.bank,
				collection.check_number,
		        collection.check_date,
				collection.cm_number,
				collection.cm_date,
			   	collection.credit_amount,
				collection.total_collected_amount,
    			
    			collection.evaluated_objective_id,
    			\'txn_sales_order_header\' sales_order_table ,
    			collection.sales_order_header_id,
    			\'txn_sales_order_header\' invoice_date_table,
    			collection.sales_order_header_id invoice_date_id,    			
    			\'so_date\' invoice_date_col,
    			collection.collection_header_id,
				collection.collection_detail_id,
    			collection.return_header_id,
    			collection.updated
    
    			';
    	
    	if($summary)
    	{
    		$select = '
    				SUM(collection.so_total_served) so_total_served,
    				SUM(collection.so_total_item_discount) so_total_item_discount,
    				SUM(collection.so_total_collective_discount) so_total_collective_discount,
    				SUM(collection.total_invoice_amount) total_invoice_amount,
    				SUM(collection.RTN_total_gross) RTN_total_gross,
    				SUM(collection.RTN_total_collective_discount) RTN_total_collective_discount,
    				SUM(collection.other_deduction_amount) other_deduction_amount,
    				SUM(collection.RTN_net_amount) RTN_net_amount,
    				SUM(collection.total_invoice_net_amount) total_invoice_net_amount,
    				SUM(collection.cash_amount) cash_amount,
    				SUM(collection.check_amount) check_amount,
    				SUM(collection.credit_amount) credit_amount,
    				(SUM(collection.cash_amount) + SUM(collection.check_amount) + SUM(collection.credit_amount)) total_collected_amount	
    				';
    	}
    	
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))
    					->selectRaw($select);
    	
    	$invoiceNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumberFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('collection.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$orNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $orNumberFilter->addFilter($prepare,'or_number',
    			function($self, $model){
    				return $model->where('collection.or_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	
    	$nameFilter = FilterFactory::getInstance('Text');
    	$prepare = $nameFilter->addFilter($prepare,'customer_name',
    			function($self, $model){
    				return $model->where('collection.customer_name','LIKE','%'.$self->getValue().'%');
    			});
    	    	
    	
    	$prepare->where(function($query) use ($noInvoice){
    		if(!$noInvoice)
    		{
    			$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    			$query = $invoiceDateFilter->addFilter($query,'invoice_date',
    					function($self, $model){
    						return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    					});
    		}
    		
    		$collectionDateFilter = FilterFactory::getInstance('DateRange');
    		$query = $collectionDateFilter->addFilter($query,'collection_date',
    				function($self, $model){
    					return $model->whereBetween('collection.or_date',$self->formatValues($self->getValue()));
    				});
    		 
    		$postingDateFilter = FilterFactory::getInstance('DateRange');
    		$query = $postingDateFilter->addFilter($query,'posting_date',
    				function($self, $model){
    					return $model->whereBetween('collection.invoice_posting_date',$self->formatValues($self->getValue()),'or');
    				});
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
     * Return Prepared Sales Collection
     * @return unknown
     */
    public function getPreparedSalesCollection2($summary = false, $except='')
    {
    	$query = ' SELECT
    			   sotbl.so_number,
    			   tas.reference_num,
    			   tas.salesman_code,
				   tas.customer_code,
    			   ac.area_code,
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
				   ti.invoice_number,
    			   ti.invoice_date,
				   coalesce(sotbl.so_total_served,0.00) so_total_served,
				   coalesce(sotbl.so_total_item_discount,0.00) so_total_item_discount,
				   coalesce(sotbl.so_total_collective_discount,0.00) so_total_collective_discount,
    			   sotbl.sfa_modified_date invoice_posting_date,
				   (coalesce(sotbl.so_total_served,0.00) - coalesce(sotbl.so_total_item_discount,0.00) - coalesce(sotbl.so_total_collective_discount,0.00)) total_invoice_amount,
    			   tsohd2.ref_no,		
			  	   coalesce(sotbl.so_total_ewt_deduction, 0.00) other_deduction_amount,	
				   rtntbl.return_slip_num,
				   coalesce(rtntbl.RTN_total_gross,0.00) RTN_total_gross,
				   coalesce(rtntbl.RTN_total_collective_discount,0.00) RTN_total_collective_discount,
				   coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00) RTN_net_amount,
				   (coalesce((coalesce(sotbl.so_total_served,0) - coalesce(sotbl.so_total_item_discount,0) - coalesce(sotbl.so_total_collective_discount,0.00)),0.00) - coalesce(sotbl.so_total_ewt_deduction, 0.00) - coalesce((rtntbl.RTN_total_gross - rtntbl.RTN_total_collective_discount),0.00)) total_invoice_net_amount,
    			
				   coltbl.or_date,
	               UPPER(coltbl.or_number) or_number,
				   IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, \'\') cash_amount,
				   IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, \'\') check_amount,
				   coltbl.bank,
				   coltbl.check_number,
				   IF(coltbl.payment_method_code=\'CASH\',\'\', coltbl.check_date) check_date,
				   coltbl.cm_number,
				   IF(coltbl.payment_method_code=\'CASH\',\'\', ti.invoice_date) cm_date,
			   	   IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0.00) credit_amount,
				   (IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0)) total_collected_amount,
    			
    			   remarks.evaluated_objective_id,
    			   sotbl.sales_order_header_id,
    			   coltbl.collection_header_id,
    			   coltbl.collection_detail_id,
    			   coltbl.collection_invoice_id,
    			   ti.invoice_id,
    			   rtntbl.return_header_id,    			   
    			   IF(sotbl.updated=\'modified\',sotbl.updated,IF(rtntbl.updated=\'modified\',rtntbl.updated,IF(coltbl.updated=\'modified\',coltbl.updated,\'\'))) updated				
    	
				   from txn_activity_salesman tas
				   left join app_customer ac on ac.customer_code=tas.customer_code
				   left join
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
    						all_so.sfa_modified_date,
							sum(all_so.total_served) as so_total_served,
							sum(all_so.total_discount) as so_total_item_discount,
						
							sum(tsohd.collective_discount_amount) as so_total_collective_discount,
							sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction,						
    			
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
    						trh.return_header_id,
							trh.return_txn_number,
							trh.reference_num,
							trh.salesman_code,
							trh.customer_code,
							trh.return_date,
							trh.return_slip_num,
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
							coalesce(tch.or_amount,0.00) or_amount,
							tch.or_date,
							tcd.payment_method_code,
							coalesce(tcd.payment_amount,0.00) payment_amount,
							tcd.check_number,
							tcd.check_date,
							tcd.bank,
							tcd.cm_number,
    						tch.collection_header_id,
    						tcd.collection_detail_id,
    						tci.invoice_number,
    						tci.collection_invoice_id,
    						IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
			
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
    					group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code,tcd.collection_detail_id
					) coltbl on coltbl.reference_num = tas.reference_num
			
					join txn_invoice ti on coltbl.invoice_number=ti.invoice_number and coltbl.salesman_code=ti.salesman_code
	    			left join
					(
						select evaluated_objective_id,remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
					) remarks ON(remarks.reference_num=tas.reference_num)
			
					WHERE  ((tas.activity_code like \'%C%\' AND tas.activity_code not like \'%SO%\')
    					   OR (tas.activity_code like \'%SO%\')
    					   OR (tas.activity_code not like \'%C%\')) '.$except.'
					ORDER BY tas.reference_num ASC,
					 		 tas.salesman_code ASC,
							 tas.customer_code ASC
    			';
    
    	$select = '
    			collection.so_number,
    			collection.reference_num,
    			collection.customer_code,
				collection.customer_name,
    			collection.customer_address,
				collection.remarks,
				collection.invoice_number,
				collection.invoice_date,
				collection.so_total_served,
				collection.so_total_item_discount,
				collection.so_total_collective_discount,
				collection.total_invoice_amount,
    			collection.ref_no,
				collection.other_deduction_amount,
				collection.return_slip_num,
				collection.RTN_total_gross,
				collection.RTN_total_collective_discount,
				collection.RTN_net_amount,
				collection.total_invoice_net_amount,
				collection.or_date,
	            collection.or_number,
				collection.cash_amount,
				collection.check_amount,
				collection.bank,
				collection.check_number,
		        collection.check_date,
				collection.cm_number,
				collection.cm_date,
			   	collection.credit_amount,
				collection.total_collected_amount,
    
    			
    			collection.evaluated_objective_id,
    			\'txn_invoice\' sales_order_table ,    			
    			collection.invoice_id sales_order_header_id,
    			\'txn_invoice\' invoice_date_table,
    			collection.invoice_id invoice_date_id,    			
    			\'invoice_date\' invoice_date_col,
    			collection.collection_header_id,
				collection.collection_detail_id,
    			collection.return_header_id,
    			collection.updated
    
    			';
    	 
    	if($summary)
    	{
    		$select = '
    				SUM(collection.so_total_served) so_total_served,
    				SUM(collection.so_total_item_discount) so_total_item_discount,
    				SUM(collection.so_total_collective_discount) so_total_collective_discount,
    				SUM(collection.total_invoice_amount) total_invoice_amount,
    				SUM(collection.RTN_total_gross) RTN_total_gross,
    				SUM(collection.RTN_total_collective_discount) RTN_total_collective_discount,
    				SUM(collection.RTN_net_amount) RTN_net_amount,
    				SUM(collection.total_invoice_net_amount) total_invoice_net_amount,
    				SUM(collection.cash_amount) cash_amount,
    				SUM(collection.check_amount) check_amount,
    				SUM(collection.total_collected_amount) total_collected_amount
    				';
    	}
    	 
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))
    	->selectRaw($select);
    	 
    	$invoiceNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumberFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('collection.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$orNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $orNumberFilter->addFilter($prepare,'or_number',
    			function($self, $model){
    				return $model->where('collection.or_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	 
    	$nameFilter = FilterFactory::getInstance('Text');
    	$prepare = $nameFilter->addFilter($prepare,'customer_name',
    			function($self, $model){
    				return $model->where('collection.customer_name','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    		$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    				function($self, $model){
    					return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    				});
    	
    	 
    	$collectionDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $collectionDateFilter->addFilter($prepare,'collection_date',
    			function($self, $model){
    				return $model->whereBetween('collection.or_date',$self->formatValues($self->getValue()));
    			});
    	 
    	$postingDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingDateFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween('collection.invoice_posting_date',$self->formatValues($self->getValue()));
    			});
    
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse %'); 
    	
    	$prepare->orderBy('collection.invoice_date','asc');
    	$prepare->orderBy('collection.customer_name','asc');
    	$prepare->orderBy('collection.so_number','asc');
    	     	
    	return $prepare;
    }
    
    /**
     * Get Sales & Collection Posting records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionPosting()
    {
    	$prepare = $this->getPreparedSalesCollectionPosting();
    	$collection1 = $prepare->get();
    	
    	$referenceNum = [];
    	foreach($collection1 as $col)
    	{
    		$referenceNum[] = $col->reference_num;
    	}
    	
    	array_unique($referenceNum);
    	$except = $referenceNum ? ' AND (tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\')) ' : '';

    	$prepare = $this->getPreparedSalesCollectionPosting2($except);
    	$collection2 = $prepare->get();
    	
    	$collection = array_merge((array)$collection1,(array)$collection2);
    	$invoices = [];
    	foreach($collection as $col)
    		$invoices[] = $col->invoice_number;
    	    		
    	sort($invoices,SORT_NATURAL);
    	
    	$records = [];
    	$reference = [];
    	foreach($invoices as $invoice)
    	{
    		foreach($collection as $col)
    		{
    			if(isset($col->invoice_number) && $invoice == $col->invoice_number && !in_array($col->reference_num,$reference))
    			{
    				$records[] = $col;
    				$reference[] = $col->reference_num;
    			}
    		}
    	}
    	    	
    	$data['records'] = $this->validateInvoiceNumber($records);
    	$data['total'] = count($records);
    	
    	return response()->json($data);    	
    }
    
    /**
     * Return prepared sales collection posting
     * @return \Illuminate\Http\JsonResponse|unknown
     */
    public function getPreparedSalesCollectionPosting()
    {
    	$query = '
    		select
    			tas.reference_num,
				tas.activity_code,
    			aps.salesman_code,
				aps.salesman_name,
				tas.customer_code,
    			ac.area_code,
				CONCAT(ac.customer_name,ac.customer_name2) customer_name,
				remarks.remarks,
				sotbl.invoice_number invoice_number,
    			IF(tas.activity_code=\'O,C\',\'\',((coalesce(sotbl.so_total_served,0.00)-coalesce(sotbl.so_total_collective_discount,0.00)) - coalesce(sotbl.so_total_ewt_deduction, 0.00) - (coalesce(rtntbl.RTN_total_gross,0.00) - coalesce(rtntbl.RTN_total_collective_discount,0.00)))) total_invoice_net_amount,
				IF(tas.activity_code=\'O,C\',\'\',sotbl.so_date) invoice_date,
				IF(tas.activity_code=\'O,C\',\'\',sotbl.sfa_modified_date) invoice_posting_date,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.or_number) or_number,
				IF(tas.activity_code=\'O,SO\',\'\',coalesce(coltbl.or_amount,0.00)) or_amount,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.or_date) or_date,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.sfa_modified_date) collection_posting_date,
    			IF(sotbl.updated=\'modified\',sotbl.updated,IF(rtntbl.updated=\'modified\',rtntbl.updated,IF(coltbl.updated=\'modified\',coltbl.updated,\'\'))) updated	
			    	
			from txn_activity_salesman tas
			left join app_salesman aps on aps.salesman_code = tas.salesman_code
			left join app_customer ac on ac.customer_code = tas.customer_code
			join
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
    				sum(tsohd.collective_discount_amount) as so_total_collective_discount,
					sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction,
    				all_so.updated
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
							sum(tsod.discount_amount) as total_discount,
    						IF(tsoh.updated_by,\'modified\',IF(tsod.updated_by,\'modified\',\'\')) updated
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
							0.00 as total_discount,
    						IF(tsoh.updated_by,\'modified\',IF(tsodeal.updated_by,\'modified\',\'\')) updated
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
    					sum(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_discount_amount,
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
    				sum(IF(trd.gross_amount,trd.gross_amount,0.00) + IF(trd.vat_amount,trd.vat_amount,0.00)) as RTN_total_gross,
					sum(IF(trhd.collective_discount_amount,trhd.collective_discount_amount,0.00)) as RTN_total_collective_discount,
					sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount)
									- sum(trhd.collective_discount_amount)
									as rtn_net_amount,
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
    				tch.or_date,
    				tci.invoice_number,
					tch.sfa_modified_date,
    				IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated					
				from txn_collection_header tch
				inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
				left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
    			group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code 
			) coltbl on coltbl.invoice_number = sotbl.invoice_number
			left join
			(
				select remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
			) remarks ON(remarks.reference_num=tas.reference_num)
    			    	
			WHERE (tas.activity_code like \'%SO%\')
			ORDER BY tas.reference_num ASC,
			 		 tas.salesman_code ASC,
					 tas.customer_code ASC
			    
    			';
    	
    	$select = '
    			collection.reference_num,
    			collection.activity_code,
				collection.salesman_name,
				collection.customer_code,
				collection.customer_name,
				collection.remarks,
				collection.invoice_number,
				collection.total_invoice_net_amount,
				collection.invoice_date,
				collection.invoice_posting_date,
				collection.or_number,
				collection.or_amount,
				collection.or_date,	            
				collection.collection_posting_date,
    			collection.updated
    			'; 
    	
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))
    					->selectRaw($select);
    	
    	$invoiceNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumberFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('collection.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$orNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $orNumberFilter->addFilter($prepare,'or_number',
    			function($self, $model){
    				return $model->where('collection.or_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	
    	$nameFilter = FilterFactory::getInstance('Text');
    	$prepare = $nameFilter->addFilter($prepare,'customer_name',
    			function($self, $model){
    				return $model->where('collection.customer_name','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){
    				return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    			});
    	
    	$collectionDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $collectionDateFilter->addFilter($prepare,'collection_date',
    			function($self, $model){
    				return $model->whereBetween('collection.collection_posting_date',$self->formatValues($self->getValue()));
    			});
    	
    	$postingDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween('collection.collection_posting_date',$self->formatValues($self->getValue()));
    			});
    	
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('collection.invoice_date','desc');
    	}
    	
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse %');
    	
    	return $prepare;
    }
    
    
    /**
     * Return prepared sales collection posting
     * @return \Illuminate\Http\JsonResponse|unknown
     */
    public function getPreparedSalesCollectionPosting2($except='')
    {
    	$query = '
    		select
    			tas.reference_num,
				tas.activity_code,
    			aps.salesman_code,
				aps.salesman_name,
				tas.customer_code,
    			ac.area_code,
				CONCAT(ac.customer_name,ac.customer_name2) customer_name,
				remarks.remarks,
				ti.invoice_number,
    			0.00 total_invoice_net_amount,				
    			ti.invoice_date,
				\'\' invoice_posting_date,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.or_number) or_number,
				IF(tas.activity_code=\'O,SO\',0.00,coltbl.or_amount) or_amount,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.or_date) or_date,
				IF(tas.activity_code=\'O,SO\',\'\',coltbl.sfa_modified_date) collection_posting_date,
    			IF(coltbl.updated=\'modified\',coltbl.updated,\'\') updated
    
			from txn_activity_salesman tas
			left join app_salesman aps on aps.salesman_code = tas.salesman_code
			left join app_customer ac on ac.customer_code = tas.customer_code
			-- COLLECTION SUBTABLE
			join
			(
				select
					tch.reference_num,
					tch.salesman_code,
					tch.or_number,
					tch.or_amount,
    				tch.or_date,
    				tci.invoice_number,
					tch.sfa_modified_date,
    				IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
				from txn_collection_header tch
				inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
				left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
    			group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code
			) coltbl on coltbl.reference_num = tas.reference_num
    		join txn_invoice ti on coltbl.invoice_number=ti.invoice_number and coltbl.salesman_code=ti.salesman_code
			left join
			(
				select remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
			) remarks ON(remarks.reference_num=tas.reference_num)
    
			WHERE (tas.activity_code like \'%C%\' AND tas.activity_code not like \'%SO%\') ' .$except. '
			ORDER BY tas.reference_num ASC,
			 		 tas.salesman_code ASC,
					 tas.customer_code ASC
			 
    			';
    	 
    	$select = '
    			collection.reference_num,
    			collection.activity_code,
				collection.salesman_name,
				collection.customer_code,
				collection.customer_name,
				collection.remarks,
				collection.invoice_number,
				collection.total_invoice_net_amount,
				collection.invoice_date,
				collection.invoice_posting_date,
				collection.or_number,
				collection.or_amount,
				collection.or_date,
				collection.collection_posting_date,
    			collection.updated
    			';
    	 
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))
    	->selectRaw($select);
    	 
    	$invoiceNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumberFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('collection.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$orNumberFilter = FilterFactory::getInstance('Text');
    	$prepare = $orNumberFilter->addFilter($prepare,'or_number',
    			function($self, $model){
    				return $model->where('collection.or_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    			function($self, $model){
    				return $model->where('collection.salesman_code','=',$self->getValue());
    			});
    	 
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	 
    	$nameFilter = FilterFactory::getInstance('Text');
    	$prepare = $nameFilter->addFilter($prepare,'customer_name',
    			function($self, $model){
    				return $model->where('collection.customer_name','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){
    				return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    			});
    	 
    	$collectionDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $collectionDateFilter->addFilter($prepare,'collection_date',
    			function($self, $model){
    				return $model->whereBetween('collection.collection_posting_date',$self->formatValues($self->getValue()));
    			});
    	 
    	$postingDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween('collection.collection_posting_date',$self->formatValues($self->getValue()));
    			});
    	 
    	 
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('collection.invoice_date','desc');
    	}
    	 
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse %');
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('collection.area_code',$codes);
    	}
    	 
    	 
    	return $prepare;
    }
    
    /**
     * Get Sales & Collection Posting records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionSummary()
    {
    	$prepare = $this->getPreparedSalesCollectionSummary();
    	$result = $this->paginate($prepare);
		$data['records'] = $this->validateInvoiceNumber($this->populateScrInvoice($result->items()));
    	 
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedSalesCollectionSummary(true);
    		$data['summary'] = $prepare->first();
    	}
    	    	 
    	$data['total'] = $result->total();
    	
    	return response()->json($data);  
    }
    
    /**
     * Populate scr invoice
     * @param array $items
     * @return unknown
     */
    public function populateScrInvoice($items = [])
    {
    	
    	$codes = $this->getSpecialCustomerCode();    	
    	$except = '';
    	if($codes)
    	{
    		$except = " AND tsoh.customer_code NOT IN('".implode("','",$codes)."')";    		
    	}
    	
    	$selectMin = 'min(tsoh.invoice_number) invoice_number';
    	$selectMax = 'max(tsoh.invoice_number) invoice_number';
    	
    	if($this->request->get('salesman'))
    		$except .= " AND tsoh.salesman_code ='".$this->request->get('salesman')."'";
    	
    	if($this->request->get('company_code'))
    		$except .= " AND tsoh.customer_code LIKE '".$this->request->get('company_code')."%'";
    	
    	foreach($items as $k=>$item)
    	{
    		$date = (new Carbon($item->invoice_date))->format('Y-m-d');
    		$minInvoice = $this->getSO($selectMin,'DATE(tsoh.so_date) = \''.$date.'\''.$except);
    		$maxInvoice = $this->getSO($selectMax,'DATE(tsoh.so_date) = \''.$date.'\''.$except);
    		$minInvoice = array_shift($minInvoice);
    		$items[$k]->invoice_number_from = $minInvoice ? $minInvoice->invoice_number : '';
    		$maxInvoice = array_shift($maxInvoice);
    		$items[$k]->invoice_number_to = $maxInvoice ? $maxInvoice->invoice_number : '';
    		$items[$k]->scr_number = $item->salesman_code.'-'.$today = (new Carbon($item->or_date))->format('mdY');
    	}
    	return $items;
    }
    
    /**
     * Get Sales order
     * @param string $select
     * @param string $where
     */
    public function getSO($select='*',$where=' 1 ')
    {
    	$query = '
    			select '.$select. ' FROM
    			(select '.$select. '						
						from txn_sales_order_header tsoh
						inner join txn_sales_order_detail tsod on tsoh.reference_num = tsod.reference_num and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
    					where '.$where.'
						group by tsoh.so_number,
							tsoh.reference_num,
							tsoh.salesman_code,
							tsoh.customer_code,
							tsoh.so_date,
							tsoh.sfa_modified_date,
							tsoh.invoice_number
			    	
						union all
			    	
						select '.$select.'							
						from txn_sales_order_header tsoh
						inner join txn_sales_order_deal tsodeal on tsoh.reference_num = tsodeal.reference_num
						where '.$where.'
						group by tsoh.so_number,
							tsoh.reference_num,
							tsoh.salesman_code,
							tsoh.customer_code,
							tsoh.so_date,
							tsoh.sfa_modified_date,
							tsoh.invoice_number
					) tsoh			
    			';	
    	
    	return \DB::select(\DB::raw($query));
    }
    
    /**
     * Get prepared sales & collection summary
     * @param string $summary
     * @return unknown
     */
    public function getPreparedSalesCollectionSummary($summary = false)
    {
    	$area = $this->request->get('area') ? ' AND ac.area_code=\''.$this->request->get('area').'\'' : '';
    	$salesman = $this->request->get('salesman') ? ' AND tas.salesman_code=\''.$this->request->get('salesman').'\'' : '';
    	$company = $this->request->get('company_code') ? ' AND tas.customer_code LIKE \''.$this->request->get('company_code').'%\'' : '';
    	
    	$invoice = '';
    	if($from = $this->request->get('invoice_date_from'))
    	{
    		$dateFrom = (new Carbon($from))->startOfDay();
    		$dateTo = (new Carbon($from))->endOfMonth()->endOfDay();
    		$invoice = ' AND (sotbl.so_date BETWEEN \''.$dateFrom.'\' AND \''.$dateTo.'\')';
    	}
    	
        //scr_number in the select query below is only used for sorting
    	$query = '
    		select
    		tas.salesman_code,
            CONCAT(tas.salesman_code, "-", DATE_FORMAT(coltbl.or_date,"%Y%m%d")) scr_number,
    		ac.customer_name,
			tas.customer_code,
    		sotbl.invoice_number,
    		coltbl.or_date,
    		ac.area_code,
			sotbl.so_date invoice_date,	
    		TRUNCATE(ROUND(SUM((IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0.00) + coalesce(sotbl.so_total_ewt_deduction,0.00))),2),2) total_collected_amount,
    		TRUNCATE(ROUND((((SUM((IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0.00) + coalesce(sotbl.so_total_ewt_deduction,0.00))))/1.12)*0.12),2),2) sales_tax,
    		TRUNCATE(ROUND(((SUM((IF(coltbl.payment_method_code=\'CASH\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CHECK\',coltbl.payment_amount, 0.00) + IF(coltbl.payment_method_code=\'CM\',coltbl.payment_amount, 0.00) + coalesce(sotbl.so_total_ewt_deduction,0.00))))/1.12),2),2) amt_to_commission
				   			    	
			from txn_activity_salesman tas
			left join app_customer ac on ac.customer_code=tas.customer_code
			left join
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
    				all_so.sfa_modified_date,
					sum(all_so.total_served) as so_total_served,
					sum(all_so.total_discount) as so_total_item_discount,
						
					sum(tsohd.collective_discount_amount) as so_total_collective_discount,
					sum(tsohd.ewt_deduction_amount) as so_total_ewt_deduction,						
    			
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
    						trh.return_header_id,
							trh.return_txn_number,
							trh.reference_num,
							trh.salesman_code,
							trh.customer_code,
							trh.return_date,
							trh.return_slip_num,
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
				left join
				(
						select
							tch.reference_num,
							tch.salesman_code,
							tch.or_number,
							coalesce(tch.or_amount,0.00) or_amount,
							tch.or_date,
							tcd.payment_method_code,
							coalesce(tcd.payment_amount,0.00) payment_amount,
							tcd.check_number,
							tcd.check_date,
							tcd.bank,
							tcd.cm_number,
    						tch.collection_header_id,
    						tcd.collection_detail_id,
    						tci.invoice_number,
    						IF(tch.updated_by,\'modified\',IF(tcd.updated_by,\'modified\',\'\')) updated
			
						from txn_collection_header tch
						inner join txn_collection_detail tcd on tch.reference_num = tcd.reference_num and tch.salesman_code = tcd.modified_by -- added to bypass duplicate refnums
						left join txn_collection_invoice tci on tch.reference_num=tci.reference_num
    					group by tci.invoice_number,tch.or_number,tch.reference_num,tcd.payment_method_code,tcd.collection_detail_id
				) coltbl on coltbl.invoice_number = sotbl.invoice_number
			
				left join txn_invoice ti on coltbl.cm_number=ti.invoice_number and ti.document_type=\'CM\'
	    		left join
				(
						select evaluated_objective_id,remarks,reference_num,updated_by from txn_evaluated_objective group by reference_num
				) remarks ON(remarks.reference_num=tas.reference_num)
    			    	
			WHERE ((tas.activity_code like \'%C%\' AND tas.activity_code not like \'%SO%\')
    					   OR (tas.activity_code like \'%SO%\')
    					   OR (tas.activity_code not like \'%C%\'))'.$area.$salesman.$company.$invoice.
    		' GROUP BY DATE(sotbl.so_date)
			ORDER BY tas.reference_num ASC,
			 		 tas.salesman_code ASC,
					 tas.customer_code ASC
			    
    			';
    	$select = '
				collection.invoice_number,
    			collection.customer_name,
				collection.invoice_date,
    			collection.or_date,
    			collection.salesman_code,
    			collection.total_collected_amount,
    			collection.sales_tax,
    			collection.area_code,
    			collection.customer_code,
    			collection.amt_to_commission
    					
    			'; 
    	
    	if($summary)
    	{
    		$select = '
    			SUM(collection.total_collected_amount) total_collected_amount,
    			SUM(collection.sales_tax) sales_tax,
    			SUM(collection.amt_to_commission) amt_to_commission				
    			';
    	}
    	
    	$prepare = \DB::table(\DB::raw('('.$query.') collection'))
    					->selectRaw($select);
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('collection.customer_code','LIKE',$self->getValue().'%');
    			});
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',
    				function($self, $model){
    					return $model->where('collection.salesman_code','=',$self->getValue());
    				});
    	
    	$monthDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $monthDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){    				
    				return $model->whereBetween('collection.invoice_date',$self->formatValues($self->getValue()));
    			});
        	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    					return $model->where('collection.area_code','=',$self->getValue());
    				});
    	
    	$prepare->where('collection.customer_name','not like','%Adjustment%');
    	$prepare->where('collection.customer_name','not like','%Van to Warehouse%');    	

    	return $prepare;
    }
    /**
     * Get van inventory stock items
     * @param unknown $transferId
     * @param unknown $itemCodes
     * @return unknown
     */
    public function getVanInventoryStockItems($transferIds, $itemCodes)
    {
    	if(!is_array($transferIds))
    		$transferIds = array($transferIds);
    	
    	$stockItems = \DB::table('txn_stock_transfer_in_detail')
					    	->selectRaw('item_code, SUM(quantity) quantity')
					    	->whereIn('txn_stock_transfer_in_detail.item_code',$itemCodes)
					    	->whereIn('txn_stock_transfer_in_detail.stock_transfer_number',$transferIds)
					    	->groupBy('txn_stock_transfer_in_detail.item_code')
					    	->orderBy('txn_stock_transfer_in_detail.modified_date')
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
    	if(!$this->request->get('transaction_date') || $this->isSalesman() && !auth()->user()->salesman_code)
    	{
    		$data = [
    			'records' => [],
    			'replenishment' => [],
    			'short_over_stocks' => [],
    			'stock_on_hand' => [],
    			'stocks' => [],
    			'total' => 0	
    		];
    		
    		return response()->json($data);
    	}
    	
    	$goLiveDate = config('system.go_live_date');
    	$from = new Carbon($goLiveDate);
    	$to = new Carbon($this->request->get('transaction_date'));
    	if($to->lt($from))
    	{
    		$data = [
    			'records' => [],
    			'replenishment' => [],
    			'short_over_stocks' => [],
    			'stock_on_hand' => [],
    			'stocks' => [],
    			'total' => 0	
    		];
    		
    		return $reports ? [] : response()->json($data);
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
    					->selectRaw('replenishment_date, UPPER(reference_number) reference_number')
    					->leftJoin('app_salesman_van', function($join){
    						$join->on('app_salesman_van.van_code','=','txn_replenishment_header.van_code');
    						$join->where('app_salesman_van.status','=','A');
    					});
    	
    	$prepare->where(\DB::raw('DATE(txn_replenishment_header.replenishment_date)'),'=',$to->format('Y-m-d'));
    	$prepare->orderBy('txn_replenishment_header.replenishment_date','desc');
    	$prepare->orderBy('txn_replenishment_header.replenishment_header_id','desc');
    	
    	$referenceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceNumFilter->addFilter($prepare,'reference_number');
    	
    	if($this->request->has('salesman_code'))
    	{
    		$prepare = $prepare->where('app_salesman_van.salesman_code','=',$this->request->get('salesman_code'));
    	}    	    
    	    	
    	$replenishment = $prepare->first();
    	
    	$firstUpload = false;
    	
    	if($replenishment)
    	{    		
    		$replenishDate = (new Carbon($replenishment->replenishment_date))->startOfDay();
    		$areaCodes = $this->getSalesmanArea($this->request->get('salesman_code'));
    		$branchLiveDates = config('system.branch_live_date');
    		foreach($areaCodes as $code)
    		{
    			if(isset($branchLiveDates[$code]))
    			{
    				$live = new Carbon($branchLiveDates[$code]);
    				if($replenishDate->eq($live))
    				{
    					$firstUpload = true;
    					break;
    				}
    			}
    		}    		    		    		
    	}        	
    	$data['first_upload'] = $firstUpload;
    	
    	if($this->request->get('reference_number') && !$replenishment)
    	{
    		$data = [
    				'records' => [],
    				'replenishment' => [],
    				'short_over_stocks' => [],
    				'stock_on_hand' => [],
    				'stocks' => [],
    				'total' => 0
    		];
    	
    		return $reports ? [] : response()->json($data);
    	}
    			 
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
		$hasReplenishment = !empty($tempActualCount);
    	    		    	
    	
    	$data['replenishment'] = (array)$replenishment;
    	if($reports && $hasReplenishment && $firstUpload)
    	{
    		$beginningBalance = (array)$replenishment;
    		$reportRecords[] = array_merge(['customer_name'=>'<strong>Beginning Balance</strong>'],$beginningBalance);
    	}
    	
    	// Get Van Inventory stock transfer data
    	$prepare = $this->getPreparedVanInventoryStocks();
    	$stocks = $prepare->get();
    	
    	if($this->request->get('stock_transfer_number') && !$stocks)
    	{
    		$data = [
    				'records' => [],
    				'replenishment' => [],
    				'short_over_stocks' => [],
    				'stock_on_hand' => [],
    				'stocks' => [],
    				'total' => 0
    		];
    		
    		return $reports ? [] : response()->json($data);
    	}
    	
    	$stockItems = [];
    	$tempStockTransfer = [];
    	if($stocks) 
    	{
    		$transferIds = [];
    		foreach ($stocks as $stock)
	    		$transferIds[] = $stock->stock_transfer_number;
    		
	    	foreach ($transferIds as $k=>$id)
	    	{
	    		$stockItems = $this->getVanInventoryStockItems($id, $codes);	    		
	    		foreach($stockItems as $item)
	    		{
		    		$stocks[$k]->{'code_'.$item->item_code} = $item->quantity;
		    		if(!isset($tempStockTransfer['code_'.$item->item_code]))
		    			$tempStockTransfer['code_'.$item->item_code] = 0;
		    		$tempStockTransfer['code_'.$item->item_code] += $item->quantity;
	    		}
	    		if($reports)
	    			$reportRecords[] = $stocks[$k];
	    	}
    	}

    	// pull previous stock transfer
    	$tempPrevStockTransfer = [];    
    	if(!$firstUpload)
    		$tempPrevStockTransfer = $this->getPreviousStockOnHand($this->request->get('transaction_date'));
    	//dd($tempPrevStockTransfer);

    	$data['total_stocks'] = $stocks ? count($stocks) : 0;    	
    	$data['stocks'] = (array)$stocks;    	
    	    		
    	$records = [];
    	$tempInvoices = [];
    	
    	if(!$this->request->get('return_slip_num'))
    	{
	    	// Get Cusomter List
	    	$prepare = $this->getPreparedVanInventory();
	    	$results = $prepare->get();
	    	
	    	foreach($results as $result)
	    	{
	    		$sales = \DB::table('txn_sales_order_detail')
				    		->select(['item_code','served_qty','order_qty'])
				    		->where('so_number','=',$result->so_number)
				    		->whereIn('item_code',$codes)
				    		->get();
	
	    		foreach($sales as $item)
	    		{
	    			if(false !== strpos($result->customer_name, '_Van to Warehouse'))
	    				$col = 'order_qty';
	    			elseif(false !== strpos($result->customer_name, '_Adjustment'))
	    				$col = 'order_qty';
	    			else 
	    				$col = 'served_qty';	    			
	    			$result->{'code_'.$item->item_code} = '('.$item->{$col}.')';
	    			if(isset($tempInvoices['code_'.$item->item_code]))
	    				$tempInvoices['code_'.$item->item_code] += $item->{$col};
	    			else
	    				$tempInvoices['code_'.$item->item_code] = $item->{$col};    			
	    		}	
	    		
	    		$deals = \DB::table('txn_sales_order_deal')
				    		->select(['trade_item_code','trade_order_qty','trade_served_qty'])
				    		->where('reference_num','=',$result->reference_num)
				    		->whereIn('item_code',$codes)
				    		->get();
	    		
				foreach($deals as $deal)
				{
					if(false !== strpos($result->customer_name, '_Van to Warehouse'))
						$col = 'trade_order_qty';
					elseif(false !== strpos($result->customer_name, '_Adjustment'))
						$col = 'trade_order_qty';
					else
						$col = 'trade_served_qty';
					$result->{'code_'.$deal->trade_item_code} = '('.$deal->{$col}.')';
					if(isset($tempInvoices['code_'.$deal->trade_item_code]))
						$tempInvoices['code_'.$deal->trade_item_code] += $deal->{$col};
					else
						$tempInvoices['code_'.$deal->trade_item_code] = $deal->{$col};
				}
	    		
	    		$records[] = $result;
	    		if($reports)
	    			$reportRecords[] = (array)$result;
	    	}
    	}
    	
    	
    	// Get returns
    	$prepare = $this->getPreparedVanInventoryReturns();
    	$results = $prepare->get();
    	
    	if($this->request->get('return_slip_num') && !$results)
    	{
    		$data = [
    				'records' => [],
    				'replenishment' => [],
    				'short_over_stocks' => [],
    				'stock_on_hand' => [],
    				'stocks' => [],
    				'total' => 0
    		];
    	
    		return $reports ? [] : response()->json($data);
    	}

    	$tempReturns = [];    	   
    	if(!$this->request->get('invoice_number'))
    	{
	    	foreach($results as $result)
	    	{
	    		$returns = \DB::table('txn_return_detail')
				    		->select(['item_code','quantity'])
				    		->where('return_txn_number','=',$result->so_number)
				    		->whereIn('item_code',$codes)
				    		->get();
	    	
	    		foreach($returns as $item)
	    		{
	    			$result->{'code_'.$item->item_code} = $item->quantity;
	    			if(isset($tempReturns['code_'.$item->item_code]))
	    				$tempReturns['code_'.$item->item_code] += $item->quantity;
	    			else
	    				$tempReturns['code_'.$item->item_code] = $item->quantity;
	    		}
	    	    		
	    		$records[] = $result;
	    		if($reports)
	    		 	$reportRecords[] = (array)$result;
	    	}
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
    		if(!isset($tempPrevStockTransfer[$code]))	
    			$tempPrevStockTransfer[$code] = 0;
    		
    		if($firstUpload)
    			$stockOnHand[$code] = $tempActualCount[$code] + $tempStockTransfer[$code] + $tempReturns[$code] - $tempInvoices[$code];
    		else
    			$stockOnHand[$code] = $tempPrevStockTransfer[$code] + $tempStockTransfer[$code] + $tempReturns[$code] - $tempInvoices[$code];
    		//$stockOnHand[$code] = $tempPrevStockTransfer[$code] + $tempStockTransfer[$code] + $tempReturns[$code] - $tempInvoices[$code];
    		//$stockOnHand[$code] = (!$stockOnHand[$code]) ? '' : $stockOnHand[$code];
    		$stockOnHand[$code] = $this->negate($stockOnHand[$code]);
    		
    		if($stockOnHand[$code])
    			$hasStockOnHand = true;
    	}
    	//dd($tempPrevStockTransfer, $tempActualCount,$tempStockTransfer, $tempReturns, $tempInvoices, $stockOnHand);
    	//dd($stockOnHand);
    	$data['records'] = $records;
    	if($records)
    		$data['total'] = count($records);
    	elseif($hasReplenishment)
    		$data['total'] = count($replenishment);
    	elseif($stocks)
    		$data['total'] = count($stocks);
    	
    	$data['stock_on_hand'] = $stockOnHand;
    	if($reports && ($records || $stocks || $hasReplenishment))
    		$reportRecords[] = array_merge(['customer_name'=>'<strong>Stock On Hand</strong>'],$stockOnHand);
    	
    	// Short over stocks
    	$shortOverStocks = [];
    	if($replenishment)
    	{
    		foreach($codes as $code)
    		{
    			$code = 'code_'.$code;
    			if(!isset($stockOnHand[$code]))
    				$stockOnHand[$code] = 0;
    			
    			$val = $stockOnHand[$code];
    			if(false !== strpos($val, '('))
    				$val = (int)str_replace(['(',')'], '', $val) * -1;
    			$shortOverStocks[$code] = isset($replenishment->{$code}) ? $replenishment->{$code} - (int)$val : (0 - (int)$val);
    		}    		
    	}
    	
    	$data['short_over_stocks'] = $shortOverStocks;
    	if($reports && $hasReplenishment)
    	{
    		$beginningBalance = (array)$replenishment;
    		unset($beginningBalance['reference_number'],$beginningBalance['replenishment_date']);
    		if(!$firstUpload)
    		{
    			$reportRecords[] = array_merge(['customer_name'=>'<strong>Actual Count</strong>'],(array)$replenishment);
    			$reportRecords[] = array_merge(['customer_name'=>'<strong>Short/Over Stocks</strong>'],$shortOverStocks);
    			$reportRecords[] = array_merge(['customer_name'=>'<strong>Beginning Balance</strong>'],$beginningBalance);
    		}
    	}
    	

    	unset($replenishment->replenishment_date);
    	unset($replenishment->reference_number);

		if (!$reports && !empty($data['records'])) {
			$this->validateInvoiceNumber($data['records']);
		}

    	return ($reports) ? $reportRecords : response()->json($data);
    }
    
    
    /**
     * Get previous stock on hand value
     * @param unknown $dateFrom
     * @return multitype:
     */
    public function getPreviousStockOnHand($dateFrom)
    {
    	$codes = [];
    	$itemCodes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code');    	 
    	foreach($itemCodes as $item)
    	{
    		$codes[] = $item->item_code;
    	}
    	

    	$goLiveDate = config('system.go_live_date');
    	
    	$from = new Carbon($goLiveDate);
    	$to = new Carbon($dateFrom);
    	if($to->lt($from))
    	{
    		return [];
    	}
    	
    	// Get previous date
    	$dateFrom = date('Y-m-d', strtotime('-1 day', strtotime($dateFrom)));
    	 
    	// Beginning Balance / Actual Count
    	// Get Replenishment data
    	$prepare = \DB::table('txn_replenishment_header')
    					->select(['replenishment_date','reference_number'])
    					->leftJoin('app_salesman_van',function($join){
    						$join->on('app_salesman_van.van_code','=','txn_replenishment_header.van_code');
    						$join->where('app_salesman_van.status','=','A');
    					});

    	if($this->request->has('salesman_code'))
    	{
    		$prepare = $prepare->where('app_salesman_van.salesman_code','=',$this->request->get('salesman_code'));
    	}
    	
    	$prepare->whereBetween(\DB::raw('DATE(txn_replenishment_header.replenishment_date)'),[$goLiveDate,$dateFrom]);
    	$prepare->orderBy('txn_replenishment_header.replenishment_date','desc');    	 
    	$replenishment = $prepare->first();

    	$tempActualCount = [];
    	if($replenishment && $codes)
    	{
    		$replenishmentItems = \DB::table('txn_replenishment_detail')
							    		->select(['item_code','quantity'])
							    		->whereIn('item_code',$codes)
							    		->where('reference_number','=',$replenishment->reference_number)
							    		->get();
    		foreach($replenishmentItems as $item)
    		{    			
    			if(!isset($tempInvoices['code_'.$item->item_code]))
    				$tempActualCount['code_'.$item->item_code] = 0;
    			$tempActualCount['code_'.$item->item_code] += $item->quantity;
    		}    	
    	}    	
    	
    	if($replenishment)
    	{
    		$dateStart = (new Carbon($replenishment->replenishment_date));
    		
    		$firstLive = false;
    		$replenishDate = (new Carbon($replenishment->replenishment_date))->startOfDay();
    		$areaCodes = $this->getSalesmanArea($this->request->get('salesman_code'));
    		$branchLiveDates = config('system.branch_live_date');
    		foreach($areaCodes as $code)
    		{
    			if(isset($branchLiveDates[$code]))
    			{
    				$live = new Carbon($branchLiveDates[$code]);
    				if($replenishDate->eq($live))
    				{
    					$firstLive = true;
    					break;
    				}
    			}
    		}
    		
    		if(!$firstLive)
    			$dateStart->addDay();
    		$dateStart = $dateStart->format('Y-m-d');    		
    	}
    	else 
    	{
    		$dateStart = $goLiveDate;
    	}	

    	$prepare = $this->getPreparedVanInventoryStocks(true);
    	$prepare = $prepare->whereBetween(\DB::raw('DATE(transfer_date)'),[$dateStart,$dateFrom]);
    	$prepare = $prepare->orderBy('transfer_date');
    	$stockTransfer = $prepare->get();
    
    	// Stock Transfer
    	$tempStockTransfer = [];
    	if($stockTransfer)
    	{
    		$transferIds = [];
    		foreach($stockTransfer as $stock)
    			$transferIds[] = $stock->stock_transfer_number;
    		$stockItems = $this->getVanInventoryStockItems($transferIds, $codes);
    		foreach($stockItems as $item)
    		{
    			if(!isset($tempStockTransfer['code_'.$item->item_code]))
    				$tempStockTransfer['code_'.$item->item_code] = 0;
    			$tempStockTransfer['code_'.$item->item_code] += $item->quantity;    			
    		}
    	}   
    	
    	// Get Invoice     	
    	$item_codes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code');
    	$itemCodes = [];
    	foreach($item_codes as $item)
    	{
    		$itemCodes[] = $item->item_code;
    	}

    	$prepare = $this->getPreparedVanInventory(true)
    				->whereBetween(\DB::raw('DATE(txn_sales_order_header.so_date)'),[$dateStart,$dateFrom]);
    	$invoices = $prepare->get();
    	foreach($invoices as $result)
    	{
    		$sales = \DB::table('txn_sales_order_detail')
			    		->select(['item_code','served_qty','order_qty'])
			    		->where('so_number','=',$result->so_number)
			    		->whereIn('item_code',$itemCodes)
			    		->get();

    		foreach($sales as $item)
    		{
    			if(false !== strpos($result->customer_name, '_Van to Warehouse'))
	    				$col = 'order_qty';
	    			elseif(false !== strpos($result->customer_name, '_Adjustment'))
	    				$col = 'order_qty';
	    			else 
	    				$col = 'served_qty';
    			if(!isset($tempInvoices['code_'.$item->item_code]))
    				$tempInvoices['code_'.$item->item_code] = 0;
    			$tempInvoices['code_'.$item->item_code] += $item->{$col};    			
    		}
    		
    		$deals = \DB::table('txn_sales_order_deal')
			    		->select(['trade_item_code','trade_order_qty','trade_served_qty'])
			    		->where('reference_num','=',$result->reference_num)
			    		->whereIn('item_code',$codes)
			    		->get();
    		 
    		foreach($deals as $deal)
    		{
    			if(false !== strpos($result->customer_name, '_Van to Warehouse'))
    				$col = 'trade_order_qty';
    			elseif(false !== strpos($result->customer_name, '_Adjustment'))
    				$col = 'trade_order_qty';
    			else
    				$col = 'trade_served_qty';
    			if(!isset($tempInvoices['code_'.$deal->trade_item_code]))
    				$tempInvoices['code_'.$deal->trade_item_code] = 0;
    			$tempInvoices['code_'.$deal->trade_item_code] += $deal->{$col};
    		}
    		
    	}
    	
    	// Get returns
    	$prepare = $this->getPreparedVanInventoryReturns(true)
    				->whereBetween(\DB::raw('DATE(txn_return_header.return_date)'),[$dateStart,$dateFrom]);
    	$results = $prepare->get();
    	
    	foreach($results as $result)
    	{
    		$returns = \DB::table('txn_return_detail')
				    		->select(['item_code','quantity'])
				    		->where('return_txn_number','=',$result->so_number)
				    		->whereIn('item_code',$itemCodes)
				    		->get();
    		 
    		foreach($returns as $item)
    		{
    			if(!isset($tempInvoices['code_'.$item->item_code]))
    				$tempInvoices['code_'.$item->item_code] = 0;
    			$tempInvoices['code_'.$item->item_code] -= $item->quantity;    			
    		}
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
    		/* if(!isset($tempReturns[$code]))
    			$tempReturns[$code] = 0; */
    		if(!isset($tempInvoices[$code]))
    			$tempInvoices[$code] = 0;
    		
    		$stockOnHand[$code] = $tempActualCount[$code] + $tempStockTransfer[$code] - $tempInvoices[$code];
    		$stockOnHand[$code] = (!$stockOnHand[$code]) ? '' : $stockOnHand[$code];    		
    	}
    	 
    	//dd($tempActualCount, $tempStockTransfer, $tempInvoices, $stockOnHand);
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
    public function getPreparedVanInventoryStocks($noTransaction=false)
    {
    	$type = $this->request->get('inventory_type') == 'canned'? '1000' : '2000';
    	
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->selectRaw('txn_stock_transfer_in_header.stock_transfer_in_header_id,
    								txn_stock_transfer_in_header.transfer_date transaction_date,
    								UPPER(txn_stock_transfer_in_header.stock_transfer_number) as stock_transfer_number,
    								IF(txn_stock_transfer_in_header.updated_by,\'modified\',\'\') updated')
    					->join(\DB::raw(
    						'(select stock_transfer_number from txn_stock_transfer_in_detail WHERE item_code LIKE \''.$type.'%\' GROUP BY stock_transfer_number) tsin'
    						), function ($join){
					    		$join->on('txn_stock_transfer_in_header.stock_transfer_number','=','tsin.stock_transfer_number');
			    	});
    	 
    	if(!$noTransaction)
    	{
	    	$transactionFilter = FilterFactory::getInstance('Date');
	    	$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
			    			function($self, $model){
			    				return $model->where(\DB::raw('DATE(txn_stock_transfer_in_header.transfer_date)'),'=',$self->getValue());
			    			});
    	}
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	
    	$stockTransferNumFilter = FilterFactory::getInstance('Text');
	    $prepare = $stockTransferNumFilter->addFilter($prepare,'stock_transfer_number');
    	
    	return $prepare;
    			 
    }
    
    
    /**
     * Return prepared statement for van inventory stocks count
     * @return unknown
     */
    public function getPreparedVanInventoryStocksCount($noTransaction=false)
    {
    	$type = $this->request->get('inventory_type') == 'canned'? '1000' : '2000';
    	 
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->selectRaw('txn_stock_transfer_in_header.stock_transfer_in_header_id,
    								txn_stock_transfer_in_header.transfer_date transaction_date,
    								UPPER(txn_stock_transfer_in_header.stock_transfer_number) as stock_transfer_number,
    								IF(txn_stock_transfer_in_header.updated_by,\'modified\',\'\') updated')
						->join(\DB::raw(
        							'(select stock_transfer_number from txn_stock_transfer_in_detail WHERE item_code LIKE \''.$type.'%\' GROUP BY stock_transfer_number) tsin'
        							), function ($join){
        								$join->on('txn_stock_transfer_in_header.stock_transfer_number','=','tsin.stock_transfer_number');
						});
    
		if(!$noTransaction)
        {
        	$transactionFilter = FilterFactory::getInstance('Date');
        	$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
        				function($self, $model){
        					return $model->where(\DB::raw('DATE(txn_stock_transfer_in_header.transfer_date)'),'<',$self->getValue());
        				});
        }
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
    			   txn_sales_order_header.reference_num,
    			   IF(txn_sales_order_header.updated_by,\'modified\',\'\') updated
    			';				 
    	 
    	$type = $this->request->get('inventory_type') == 'canned'? '1000' : '2000';
    	 
    	$prepare = \DB::table('txn_sales_order_header')
    				->selectRaw($select)
    				->join(\DB::raw(
    						'(select reference_num from txn_sales_order_detail WHERE item_code LIKE \''.$type.'%\' GROUP BY reference_num) tsod'
    						), function ($join){
					    		$join->on('txn_sales_order_header.reference_num','=','tsod.reference_num');
			    	})
    				->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code');
    	
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
    	
    	/* $status = $this->request->get('status') ? $this->request->get('status') : 'A';
    	$item_codes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code', $status);
    	$codes = [];
    	foreach($item_codes as $item)
    	{
    		$codes[] = $item->item_code;
    	}
    	$prepare = $prepare->whereIn('txn_sales_order_detail.item_code',$codes); */    	
    	
    	$prepare->orderBy('txn_sales_order_header.invoice_number');
    	return $prepare;
    }
    
    
    /**
     * Return prepared statement for van inventory returns
     * @return unknown
     */
    public function getPreparedVanInventoryReturns($noTransaction=false)
    {
    	$select = '
    			   app_customer.customer_name,
				   txn_return_header.return_date invoice_date,    				
				   txn_return_header.return_slip_num,
    			   txn_return_header.return_txn_number so_number,
    			   IF(txn_return_header.updated_by,\'modified\',\'\') updated
    			';
    
    	$type = $this->request->get('inventory_type') == 'canned'? '1000' : '2000';
    
    	$prepare = \DB::table('txn_return_header')
			    	->selectRaw($select)
			    	->join(\DB::raw(
			    			'(select reference_num from txn_return_detail WHERE item_code LIKE \''.$type.'%\' GROUP BY reference_num) trd'
			    	), function ($join){
			    		$join->on('txn_return_header.reference_num','=','trd.reference_num');
			    	})
			    	->leftJoin('app_customer','txn_return_header.customer_code','=','app_customer.customer_code');
    	 
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    
    	if(!$noTransaction)
    	{
    		$transactionFilter = FilterFactory::getInstance('Date');
    		$prepare = $transactionFilter->addFilter($prepare,'transaction_date',
    				function($self, $model){
    					return $model->where(\DB::raw('DATE(txn_return_header.return_date)'),'=',$self->getValue());
    				});
    	}
    
    	$returnFilter = FilterFactory::getInstance('Text');
    	$prepare = $returnFilter->addFilter($prepare,'return_slip_num');
    	 
    	/* $status = $this->request->get('status') ? $this->request->get('status') : 'A';
    	 $item_codes = $this->getVanInventoryItems($this->request->get('inventory_type'),'item_code', $status);
    	 $codes = [];
    	 foreach($item_codes as $item)
    	 {
    	 $codes[] = $item->item_code;
    	 }
    	$prepare = $prepare->whereIn('txn_sales_order_detail.item_code',$codes); */
    	 
    	$prepare->orderBy('txn_return_header.return_slip_num');
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
		$data['records'] = $this->validateInvoiceNumber($result->items());
    	
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
    public function getPreparedUnpaidInvoice($summary=false,$sync=false)
    {
    	if($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to'))
    	{
    		$from = date_create($this->request->get('invoice_date_from'));
            $to = date_create($this->request->get('invoice_date_to'));
            $filterInvoice = "DATE(%sinvoice_date) BETWEEN '".date_format($from, 'Y-m-d')."' and '".date_format($to, 'Y-m-d')."'";
    	}
    	elseif($sync)
    	{
    		$filterInvoice = "DATE(%sinvoice_date) BETWEEN '".date_format(date_create(config('system.go_live_date')), 'Y-m-d')."' and '".date_format(date_create(), 'Y-m-d')."'";
    	}
    	else
    	{
    		$filterInvoice = "DATE(%sinvoice_date) BETWEEN '".date_format(date_create(config('system.go_live_date')), 'Y-m-d')."' and '".date_format(date_create(), 'Y-m-d')."'";
    	}
    	
    	// VW_INV temporary table
    	$queryInv = '
    		(select salesman_code, customer_code, invoice_number, sum(coalesce(invoice_amount,0)) as invoice_amount, updated
            from (
                    select ti.salesman_code, ti.customer_code, ti.invoice_number, ti.original_amount as invoice_amount, \'\' updated
                  	from txn_invoice ti
    				left join txn_sales_order_header tih
					on ti.salesman_code = tih.salesman_code
					and ti.customer_code = tih.customer_code
					and ti.invoice_number = tih.invoice_number 
    				where '.sprintf($filterInvoice,'ti.').'
                  	and ti.document_type = \'I\'
                  	and ti.status = \'A\'		
                  	and ti.customer_code in (select customer_code from app_salesman_customer where salesman_code = ti.salesman_code and status =\'A\')
    				and tih.sales_order_header_id is null		
      
                  	UNION ALL
    	
                  	select tsoh.salesman_code, tsoh.customer_code, tsoh.invoice_number,
                  	case when sum(coalesce(so_net_amt,0) + coalesce(so_deal_net_amt,0) - coalesce(tsohd.served_deduction_amount,0) - (coalesce(trd.rtn_net_amt,0) - coalesce(trhd.deduction_amount,0))) <= 0 then 0 else
                  			      sum(coalesce(so_net_amt,0) + coalesce(so_deal_net_amt,0) - coalesce(tsohd.served_deduction_amount,0) - (coalesce(trd.rtn_net_amt,0) - coalesce(trhd.deduction_amount,0))) end as invoice_amount,
                  	IF(tsoh.updated_by,\'modified\',\'\') updated		
                  	from txn_sales_order_header tsoh
			
                  	left join
					         (select reference_num,round(sum(gross_served_amount + vat_amount - discount_amount),2) as so_net_amt
							         from txn_sales_order_detail
							         group by reference_num) tsod
					         on tsoh.reference_num = tsod.reference_num
					left join (select reference_num,round(sum(gross_served_amount + vat_served_amount),2) as so_deal_net_amt 
									from txn_sales_order_deal 
							 group by reference_num) tsodeal
							on tsoh.reference_num = tsodeal.reference_num
        			left join
        					(select reference_num,round(sum(served_deduction_amount),2) as served_deduction_amount
        							from txn_sales_order_header_discount group by reference_num) tsohd
					         on tsoh.reference_num = tsohd.reference_num
			
        			left join
        					(select reference_num,round(sum(gross_amount + vat_amount - discount_amount),2) as rtn_net_amt
        							from txn_return_detail group by reference_num) trd
        					on tsoh.reference_num = trd.reference_num
			
        			left join (select reference_num,round(sum(deduction_amount),2) as deduction_amount 
																	from txn_return_header_discount 
																	group by reference_num) trhd
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
    			  IF(app_customer.address_1=\'\',
	    				IF(app_customer.address_2=\'\',app_customer.address_3,
	    					IF(app_customer.address_3=\'\',app_customer.address_2,CONCAT(app_customer.address_2,\', \',app_customer.address_3))
	    					),
	    				IF(app_customer.address_2=\'\',
	    					IF(app_customer.address_3=\'\',app_customer.address_1,CONCAT(app_customer.address_1,\', \',app_customer.address_3)),
	    					  IF(app_customer.address_3=\'\',
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2),
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2,\', \',app_customer.address_3)
	    						)
	    					)
	    		  ) customer_address,
			      f.remarks,
    			  vw_inv.invoice_number,
			      coalesce(txn_sales_order_header.so_date,txn_invoice.invoice_date) invoice_date,
			      coalesce(vw_inv.invoice_amount,0) original_amount,
			      coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0) balance_amount,
    			  vw_inv.updated
    			';
    	if($summary)
    	{
    		$select = '
			      SUM(coalesce(vw_inv.invoice_amount,0)) original_amount,
			      SUM(coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0)) balance_amount
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
    				->leftJoin('txn_sales_order_header',function($join){
    					$join->on('txn_sales_order_header.invoice_number','=','vw_inv.invoice_number');
    					/* $join->where('vw_inv.salesman_code','=','txn_sales_order_header.salesman_code');
    					$join->where('vw_inv.customer_code','=','txn_sales_order_header.customer_code'); */
    				})
    				->leftJoin('txn_invoice',function($join){
    					$join->on('txn_invoice.invoice_number','=','vw_inv.invoice_number');
    					/* $join->where('vw_inv.salesman_code','=','txn_sales_order_header.salesman_code');
    					$join->where('vw_inv.customer_code','=','txn_sales_order_header.customer_code'); */
    				})
    				->leftJoin(\DB::raw('
			    			(select remarks,reference_num
			    			 from txn_evaluated_objective
			    			 group by reference_num) f'), function($join){
    							    			 	$join->on('txn_sales_order_header.reference_num','=','f.reference_num');
    							    			 }
    				);    	
    	
    	
    	$prepare = $prepare->where(\DB::raw('coalesce(vw_inv.invoice_amount,0) - coalesce(vw_col.applied_amount,0)'),'>=','0.1');
    	
    	
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
    	
    	$invoiceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('vw_inv.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	 
    	if($this->isSalesman())
    	{
    		$prepare->where('vw_inv.salesman_code',auth()->user()->salesman_code);
    	}
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_area.area_code',$codes);
    	}
    	
    	return $prepare;
    }
    
    /**
     * Get alike area code
     * @param unknown $code
     * @return string
     */
    public function getAlikeAreaCode($code)
    {
    	$alikeCode = 2000 + $code;
    	return [$code,$alikeCode];
    }
    
    /**
     * Get Bir records
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBir()
    {  		  
    	$prepare = $this->getPreparedBir();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();    	
    	$data['total'] = $result->total();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedBir(false,true);
    		$data['summary'] = $prepare->first();
    	}
    
    	return response()->json($data);
    }
    
    /**
     * Return Prepared Bir
     * @return unknown
     */
    public function getPreparedBir($report=false,$summary=false)
    {
    	
    	$special = $this->getSpecialCustomerCode();
    	$truncate1 = 'TRUNCATE(ROUND(';
    	$truncate2 = ',2),2)';
    	
    	$querySales = '    			
				select 
    				0 negate,
					ACT.salesman_code sales_group, 
					ACT.customer_code,
					SOtbl.so_date document_date,
					coalesce(SOtbl.invoice_number, \'\') reference,'.
					$truncate1. '(((coalesce(SOtbl.SO_total_vat, 0.00) - coalesce(SOtbl.SO_total_collective_discount, 0.00))/1.12)*0.12)'.$truncate2.' tax_amount,'.					
					$truncate1. '((coalesce(SOtbl.SO_amount, 0.00) - coalesce(SOtbl.SO_total_collective_discount,0.00))/1.12)'.$truncate2.' total_sales,'.
					$truncate1. '(coalesce(SOtbl.SO_net_amount, 0.00) - coalesce(SOtbl.SO_total_collective_discount, 0.00))'.$truncate2.' total_invoice_amount,
    				SOtbl.updated,
    				app_customer.area_code					

					from txn_activity_salesman ACT 

				join				
				(
					select ALL_SO.so_number, 
						ALL_SO.reference_num,  
						ALL_SO.salesman_code, 
						ALL_SO.customer_code,
						ALL_SO.so_date,
						ALL_SO.sfa_modified_date,
						ALL_SO.invoice_number,
						sum(coalesce(ALL_SO.total_vat,0.00)) as SO_total_vat,						
						sum(tsohd.collective_discount_amount) as SO_total_collective_discount,						
						sum(coalesce(ALL_SO.so_amount, 0.00)) as SO_amount,
						sum(ALL_SO.net_amount) as SO_net_amount,
    					ALL_SO.updated
						from (
						
							select tsoh.so_number, 
								tsoh.reference_num, 
								tsoh.salesman_code, 
								tsoh.customer_code,
								tsoh.so_date,
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
								sum((coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as total_vat,
								sum((coalesce(tsod.gross_served_amount,0.00) + coalesce(tsod.vat_amount,0.00))-coalesce(tsod.discount_amount,0.00)) as so_amount,
								sum((tsod.gross_served_amount + tsod.vat_amount)-tsod.discount_amount) as net_amount,
    							IF(tsoh.updated_by,\'modified\',IF(tsod.updated_by,\'modified\',\'\')) updated
								from txn_sales_order_header tsoh
								inner join txn_sales_order_detail tsod
								on tsoh.reference_num = tsod.reference_num
								and tsoh.salesman_code = tsod.modified_by
    							where tsoh.customer_code LIKE \'1000%\' and tsoh.customer_code NOT IN(\''.implode("','",$special).'\') 
								group by tsoh.so_number, 
								tsoh.reference_num, 
								tsoh.salesman_code, 
								tsoh.customer_code,
								tsoh.so_date,
								tsoh.sfa_modified_date,
								tsoh.invoice_number

							union all

							select tsoh.so_number, 
								tsoh.reference_num, 
								tsoh.salesman_code, 								
								tsoh.customer_code,
								tsoh.so_date,
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
								sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as total_vat,
								sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as so_amount,
								sum(coalesce(tsodeal.gross_served_amount,0.00) + coalesce(tsodeal.vat_served_amount,0.00)) as net_amount,
    							IF(tsoh.updated_by,\'modified\',IF(tsodeal.updated_by,\'modified\',\'\')) updated
								from txn_sales_order_header tsoh
								inner join txn_sales_order_deal tsodeal
								on tsoh.reference_num = tsodeal.reference_num
    							where tsoh.customer_code LIKE \'1000%\' and tsoh.customer_code NOT IN(\''.implode("','",$special).'\')
								group by tsoh.so_number, 
								tsoh.reference_num, 
								tsoh.salesman_code, 
								tsoh.customer_code,
								tsoh.so_date,
								tsoh.sfa_modified_date,
								tsoh.invoice_number
																
						) ALL_SO

						
					left join
					(
						select reference_num,
						sum(case when deduction_code <> \'EWT\' then coalesce(served_deduction_amount,0) else 0 end) as collective_discount_amount
						from txn_sales_order_header_discount
						group by reference_num
					) tsohd on ALL_SO.reference_num = tsohd.reference_num

										
					group by ALL_SO.so_number, 
						ALL_SO.reference_num, 
						ALL_SO.salesman_code, 
						ALL_SO.customer_code,
						ALL_SO.so_date,
						ALL_SO.sfa_modified_date,
						ALL_SO.invoice_number	
						
				) SOtbl 
				on SOtbl.reference_num = ACT.reference_num
				and SOtbl.salesman_code = ACT.salesman_code

    			left join app_customer on app_customer.customer_code = ACT.customer_code
    									
				WHERE (ACT.activity_code like \'%SO%\' OR ACT.activity_code like \'%C%\')    			
    			';
    	    	
    	$queryRtn = '
    			select 
    				1 negate,
					ACT.salesman_code sales_group, 
					ACT.customer_code,					
					RTNtbl.return_date document_date,
					coalesce(RTNtbl.return_slip_num, \'\') reference, '.
					$truncate1 . '(-1*(((coalesce(RTNtbl.RTN_total_vat, 0.00)-coalesce(RTNtbl.RTN_total_collective_discount, 0.00))/1.12)*0.12))' .$truncate2 . ' tax_amount,'.
					$truncate1 . '(-1*((coalesce(RTNtbl.RTN_total_amount, 0.00)-coalesce(RTNtbl.RTN_total_collective_discount, 0.00))/1.12))'.$truncate2 .' total_sales,'.
					$truncate1 . '(-1*(coalesce(RTNtbl.RTN_net_amount, 0.00)-coalesce(RTNtbl.RTN_total_collective_discount, 0.00))) '.$truncate2.' total_invoice_amount,
    			    RTNtbl.updated,
					app_customer.area_code					

					from txn_activity_salesman ACT 

				join 				
				(
					select trh.return_txn_number,
						trh.reference_num, 
						trh.salesman_code, 
						trh.customer_code,
						trh.return_date, 
						trh.sfa_modified_date,
						trh.return_slip_num,
						trhd.collective_discount_amount as RTN_total_collective_discount,    			
						sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount) as RTN_total_vat,												
						sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount) as RTN_net_amount,						
						sum((trd.gross_amount + trd.vat_amount) - trd.discount_amount) as RTN_total_amount,
    					IF(trh.updated_by,\'modified\',IF(trd.updated_by,\'modified\',\'\')) updated
					from txn_return_header trh
					inner join txn_return_detail trd on trh.reference_num = trd.reference_num  and trh.salesman_code = trd.modified_by
					
					left join
					(
						select reference_num
						,sum(coalesce(deduction_amount,0)) as collective_discount_amount
						from txn_return_header_discount
						group by reference_num
    				) trhd
					on trh.reference_num = trhd.reference_num
					
    				where trh.customer_code LIKE \'1000%\' and trh.customer_code NOT IN(\''.implode("','",$special).'\')
    				
					group by trh.return_txn_number,
					trh.reference_num, 
					trh.salesman_code, 
					trh.customer_code,
					trh.return_date, 
					trh.sfa_modified_date, 
					trh.return_slip_num
											
				) RTNtbl
				on RTNtbl.reference_num = ACT.reference_num
				and RTNtbl.salesman_code = ACT.salesman_code

    			left join app_customer on app_customer.customer_code = ACT.customer_code			
    						
				WHERE (ACT.activity_code like \'%SO%\' OR ACT.activity_code like \'%C%\')
    			';
    	
    	$select = '
    			bir.negate,
    			bir.document_date,
				SUBSTRING_INDEX(app_customer.customer_name,\'_\',-1) name,
    			IF(app_customer.address_1=\'\',
    				IF(app_customer.address_2=\'\',app_customer.address_3,
    					IF(app_customer.address_3=\'\',app_customer.address_2,CONCAT(app_customer.address_2,\', \',app_customer.address_3))
    					),
    				IF(app_customer.address_2=\'\',
    					IF(app_customer.address_3=\'\',app_customer.address_1,CONCAT(app_customer.address_1,\', \',app_customer.address_3)),
    					  IF(app_customer.address_3=\'\',
    							CONCAT(app_customer.address_1,\', \',app_customer.address_2),
    							CONCAT(app_customer.address_1,\', \',app_customer.address_2,\', \',app_customer.address_3)
    						)
    					)
    			) customer_address,
				app_area.area_name depot,
				bir.reference,
				bir.tax_amount,
				bir.total_sales,
    			bir.total_sales sales,
    			bir.total_sales local_sales,
				bir.total_invoice_amount,
    			bir.total_invoice_amount term_cash,
				bir.sales_group,
    			bir.updated,
				app_salesman.salesman_name assignment,
    			bir.area_code
    			';
    	
    	if($summary)
    	{
    		$select = '
			      SUM(bir.tax_amount) tax_amount,
			      SUM(bir.total_sales) total_sales,
    			  SUM(bir.total_sales) sales,
    			  SUM(bir.total_sales) local_sales,
    			  SUM(bir.total_invoice_amount) total_invoice_amount,
    			  SUM(bir.total_invoice_amount) term_cash,		
    			  bir.negate	
    			';
    	}
    	
    	$from = '( '.$querySales.' UNION ' .$queryRtn . ' ) bir';
    	
    	$prepare = \DB::table(\DB::raw($from))
    				->selectRaw($select)
    				->leftJoin('app_customer','app_customer.customer_code','=','bir.customer_code')
    				->leftJoin('app_area','app_area.area_code','=','app_customer.area_code')
    				->leftJoin('app_salesman','app_salesman.salesman_code','=','bir.sales_group');
    	
    	$areaFilter = FilterFactory::getInstance('Select','Area',SelectFilter::SINGLE_SELECT);
    	$prepare = $areaFilter->addFilter($prepare,'area', function($self, $model){
			    		return $model->where('app_area.area_code','=',$self->getValue());
			    	});
    	
    	$salesmanFilter = FilterFactory::getInstance('Select','Salesman',SelectFilter::SINGLE_SELECT);
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman',function($self, $model){
			    		return $model->where('bir.sales_group','=',$self->getValue());
			    	});
    	
    	$documentFilter = FilterFactory::getInstance('DateRange','Month');
    	$prepare = $documentFilter->addFilter($prepare,'document_date',function($self, $model){
			    		return $model->whereBetween(\DB::raw('DATE(bir.document_date)'),$self->formatValues($self->getValue()));
			    	});
    	
    	$referenceFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceFilter->addFilter($prepare,'reference',
    				function($self, $model){
    					return $model->where('bir.reference','LIKE','%'.$self->getValue().'%');
    				});
    	
    	$nameFilter = FilterFactory::getInstance('Text');
    	$prepare = $nameFilter->addFilter($prepare,'customer_name',
    			function($self, $model){
    				return $model->where('app_customer.customer_name','LIKE','%'.$self->getValue().'%');
    			});
    	
    	//$prepare->where('bir.tax_amount','<>','0');
    	$prepare->where('app_customer.customer_name','like','1000%');
    	$prepare->where('app_customer.customer_name','not like','%Adjustment%');
    	$prepare->where('app_customer.customer_name','not like','%Van to Warehouse %');
    	//print_r($prepare->toSql());exit;
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('bir.area_code',$codes);   		
    	}
    	return $prepare;
    }
    
    /**
     * Get special customer's code
     * @return multitype:
     */
    public function getSpecialCustomerCode()
    {
    	$codes = [];
    	
    	$customers = \DB::table('app_customer')
    					->where('customer_name','like','%Adjustment%')
    					->where('customer_name','like','%Van to Warehouse %','or')
    					->get(['customer_id','customer_code']);
    	
    	foreach($customers as $customer)
    	{
    		$codes[] = $customer->customer_code;
    	}
    	
    	return $codes;
    }
    
    /**
     * Get Sales Report Per Material
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesReportMaterial()
    {
    
    	$prepare = $this->getPreparedSalesReportMaterial(); 
    		
    	$result = $this->paginate($prepare);
		$data['records'] = $this->validateInvoiceNumber($result->items());
    	
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
     * Get Prepared Sales Report Return Query
     * @param string $summary
     */
    public function getPreparedSalesReportReturnQuery($summary=false)
    {
    	$sum1 = $summary ? 'SUM(' : '';
    	$sum2 = $summary ? ')' : '';
    	$group = $summary ? ' GROUP BY trh.return_txn_number' : '';
    	
    	$queryReturns = '
    			SELECT
				trh.return_txn_number so_number,
    			trh.reference_num,
				tas.activity_code,
				trh.customer_code,
				ac.customer_name,
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
                remarks.evaluated_objective_id,
				trh.van_code,
				trh.device_code,
				trh.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
				trh.return_slip_num invoice_number,
				trh.return_date invoice_date,
				trh.sfa_modified_date invoice_posting_date,
				aim.segment_code,
				aim.item_code,
				aim.description,
				trd.quantity,
				trd.return_detail_id,
				trd.condition_code,
				trd.uom_code,
				(-1 * TRUNCATE(ROUND('.$sum1.'trd.gross_amount'.$sum2.',2),2)) gross_served_amount,
				(-1 * TRUNCATE(ROUND('.$sum1.'trd.vat_amount'.$sum2.',2),2)) vat_amount,
				0 discount_rate,
				(-1 * TRUNCATE(ROUND('.$sum1.'trd.discount_amount'.$sum2.',2),2)) discount_amount,
				trhd.deduction_rate collective_discount_rate,
    			(-1 * TRUNCATE(ROUND('.$sum1.'(coalesce((trd.gross_amount + trd.vat_amount),0.00)*(coalesce(trhd.deduction_rate,0.00)/100))'.$sum2.',2),2)) collective_discount_amount,
			    trhd.ref_no discount_reference_num,
			    trhd.remarks discount_remarks,
			    (-1 * TRUNCATE(ROUND('.$sum1.'((trd.gross_amount + trd.vat_amount) - coalesce(trd.discount_amount,0.00)) - (coalesce((trd.gross_amount + trd.vat_amount),0.00)*(coalesce(trhd.deduction_rate,0.00)/100))'.$sum2.',2),2)) total_invoice,
			    IF(trh.updated_by,\'modified\',IF(trd.updated_by,\'modified\',\'\')) updated,
    	
				\'txn_return_header\' invoice_table,
    			\'return_slip_num\' invoice_number_column,
    			\'return_date\' invoice_date_column,
    			\'sfa_modified_date\' invoice_posting_date_column,
				trh.return_header_id invoice_pk_id,
    			\'txn_return_detail\' quantity_table,
    			\'quantity\' quantity_column,
				trd.return_detail_id quantity_pk_id,
    			\'txn_return_detail\' condition_code_table,
    			\'condition_code\' condition_code_column,
				trd.return_detail_id condition_code_pk_id
    	
			FROM txn_return_header trh
			LEFT JOIN app_customer ac ON(ac.customer_code=trh.customer_code)
			LEFT JOIN app_area aa ON(aa.area_code=ac.area_code)
			LEFT JOIN app_salesman aps ON(aps.salesman_code=trh.salesman_code)
			LEFT JOIN txn_activity_salesman tas ON(tas.salesman_code=trh.salesman_code AND tas.reference_num=trh.reference_num)
			LEFT JOIN txn_return_detail trd ON(trh.reference_num=trd.reference_num)
			LEFT JOIN app_item_master aim ON(aim.item_code=trd.item_code)
    		LEFT JOIN
    		(
    			select
    				reference_num,
			    	ref_no,
			    	remarks,
    				deduction_rate,
    				sum(coalesce(deduction_amount,0)) served_deduction_amount
					from  txn_return_header_discount
    				where deduction_code <> \'EWT\'
					group by reference_num
    		) trhd ON(trhd.reference_num=trh.reference_num)
    	
    		LEFT JOIN (
    				select reference_num,remarks,evaluated_objective_id from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    		) remarks ON(remarks.reference_num = trh.reference_num)
			    		
			'. $group;
    	
    	return $queryReturns;
    }
    
    /**
     * Returns the prepared statement for Sales Report Per Material
     * @return Builder 
     */
    public function getPreparedSalesReportMaterial($summary=false)
    {
    	$querySales = '
    			SELECT
				all_so.so_number,
    			all_so.reference_num,
				tas.activity_code,
				all_so.customer_code,
				ac.customer_name,
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
                remarks.evaluated_objective_id,
			    all_so.van_code,
				all_so.device_code,
				all_so.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
				all_so.invoice_number,
				all_so.so_date invoice_date,
				all_so.sfa_modified_date invoice_posting_date,
				aim.segment_code,
				aim.item_code,
				aim.description,
			    IF(\'Adjustment\'=SUBSTR(ac.customer_name,6),all_so.order_qty,
    				IF(\'Van to Warehouse Transaction\'=SUBSTR(ac.customer_name,6),all_so.order_qty,all_so.served_qty)) quantity,
			    0 return_detail_id,
				\'\' condition_code,
				all_so.uom_code,
				TRUNCATE(ROUND(all_so.gross_served_amount,2),2) gross_served_amount,
				TRUNCATE(ROUND(all_so.vat_amount,2),2) vat_amount,
				all_so.discount_rate,
				TRUNCATE(ROUND(all_so.discount_amount,2),2) discount_amount,
			    all_so.collective_discount_rate,
    			TRUNCATE(ROUND(all_so.collective_discount_amount,2),2) collective_discount_amount,
			    all_so.discount_reference_num,
			    all_so.discount_remarks,
			    TRUNCATE(all_so.total_sales,2) total_invoice,
				IF(all_so.updated =\'modified\',\'modified\',\'\') updated,		
				\'txn_sales_order_header\' invoice_table,
				\'invoice_number\' invoice_number_column,
				\'so_date\' invoice_date_column,
				\'sfa_modified_date\' invoice_posting_date_column,
				all_so.sales_order_header_id invoice_pk_id,
				all_so.quantity_table,
				all_so.quantity_column,
				all_so.quantity_pk_id,
				\'\' condition_code_table,
				\'\' condition_code_column,
				0 condition_code_pk_id
		
		
				FROM 
    			(
    				 -- For SO Regular Skus --
						 select 
    							tsoh.sales_order_header_id,
    							\'txn_sales_order_detail\' quantity_table,
								IF(\'Adjustment\'=SUBSTR(ac.customer_name,6),\'order_qty\',
    								IF(\'Van to Warehouse Transaction\'=SUBSTR(ac.customer_name,6),\'order_qty\',\'served_qty\')) quantity_column,
								tsod.sales_order_detail_id quantity_pk_id,
    							tsoh.so_number, 
								tsoh.reference_num,
    							tsoh.customer_code, 
								tsoh.salesman_code, 
				    			tsoh.van_code,
								tsoh.device_code,				
								tsoh.sfa_modified_date,
								tsoh.invoice_number,    							
    							tsoh.so_date,    			
    							tsod.uom_code,
    							tsod.item_code,
								tsod.gross_served_amount,
								tsod.vat_amount,
								tsod.discount_rate,
								tsod.discount_amount,
    							tsod.served_qty,
    							tsod.order_qty,    			
    							tsohd.served_deduction_rate collective_discount_rate,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,
    							coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100) collective_discount_amount,
								(coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)-coalesce((tsod.discount_amount+coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)),0.00)) total_sales,
    							IF(tsoh.updated_by,\'modified\', IF(tsod.updated_by,\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_detail tsod
								on tsoh.reference_num = tsod.reference_num
								and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
    							left join txn_sales_order_header_discount tsohd on tsoh.reference_num = tsohd.reference_num and tsohd.deduction_code <> \'EWT\'
    							LEFT JOIN app_customer ac ON(ac.customer_code=tsoh.customer_code)    							

							union all

							-- For SO Deals --
								select
    							tsoh.sales_order_header_id, 
    							\'txn_sales_order_deal\' quantity_table,
    							IF(\'Adjustment\'=SUBSTR(ac.customer_name,6),\'regular_order_qty\',
    								IF(\'Van to Warehouse Transaction\'=SUBSTR(ac.customer_name,6),\'regular_order_qty\',\'regular_served_qty\')) quantity_column,
								tsodeal.so_detail_deal_id quantity_pk_id,
    							tsoh.so_number, 
								tsoh.reference_num,
    							tsoh.customer_code, 
								tsoh.salesman_code, 
				    			tsoh.van_code,
								tsoh.device_code,				
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
    							tsoh.so_date,    			
    							tsodeal.uom_code,
    							tsodeal.item_code,
								tsodeal.gross_served_amount,
								tsodeal.vat_served_amount vat_amount,
								0.00 discount_rate,
								0.00 discount_amount,  
    							tsodeal.regular_served_qty served_qty,
    							tsodeal.regular_order_qty order_qty,
    							tsohd.served_deduction_rate collective_discount_rate,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,  		
    							coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100) collective_discount_amount,	
								(coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)-coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) total_sales,
    							IF(tsoh.updated_by,\'modified\', IF(tsodeal.updated_by,\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_deal tsodeal
								on tsoh.reference_num = tsodeal.reference_num
    							left join txn_sales_order_header_discount tsohd on tsoh.reference_num = tsohd.reference_num and tsohd.deduction_code <> \'EWT\'
    							LEFT JOIN app_customer ac ON(ac.customer_code=tsoh.customer_code)    							
								
    			) all_so
				LEFT JOIN app_customer ac ON(ac.customer_code=all_so.customer_code)
				LEFT JOIN app_area aa ON(ac.area_code=aa.area_code)
				LEFT JOIN app_salesman aps ON(aps.salesman_code=all_so.salesman_code)
				LEFT JOIN txn_activity_salesman tas ON(tas.reference_num=all_so.reference_num AND tas.salesman_code=all_so.salesman_code)
				LEFT JOIN app_item_master aim ON(all_so.item_code=aim.item_code)
    			LEFT JOIN (
    				select reference_num,remarks,evaluated_objective_id from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    			) remarks ON(remarks.reference_num = tas.reference_num)								
    			';
    	 
    	$queryReturns = $this->getPreparedSalesReportReturnQuery($summary);
    	 
    	$select = '
    			sales.so_number,
    			sales.reference_num,
				sales.activity_code,
				sales.customer_code,
				sales.customer_name,
    			sales.customer_address,
    			sales.remarks,
                sales.evaluated_objective_id,
			    sales.van_code,
				sales.device_code,
				sales.salesman_code,
				sales.salesman_name,
				sales.area,
				sales.invoice_number,
				sales.invoice_date,
				sales.invoice_posting_date,
				sales.segment_code,
				sales.item_code,
				sales.description,
			    sales.quantity,
			    sales.condition_code,
				sales.uom_code,
				sales.gross_served_amount,
				sales.vat_amount,
				CONCAT(TRUNCATE(coalesce(sales.discount_rate,0.00),0),\'%\') discount_rate,
				sales.discount_amount,
    			CONCAT(TRUNCATE(coalesce(sales.collective_discount_rate,0.00),0),\'%\') collective_discount_rate,
    			sales.collective_discount_amount,
			    sales.discount_reference_num,
			    sales.discount_remarks,			    
			    sales.total_invoice,
				sales.updated,
				sales.invoice_table,
				sales.invoice_number_column,
				sales.invoice_date_column,
				sales.invoice_posting_date_column,
				sales.invoice_pk_id,
				sales.quantity_table,
				sales.quantity_column,
				sales.quantity_pk_id,
				sales.condition_code_table,
				sales.condition_code_column,
				sales.condition_code_pk_id
    			';
    	
    	if($summary)
    	{
    		$select = '
				   SUM(sales.quantity) quantity,
				   TRUNCATE(ROUND(SUM(sales.gross_served_amount),2),2) gross_served_amount,
    			   TRUNCATE(ROUND(SUM(sales.discount_amount),2),2) discount_amount,
				   TRUNCATE(ROUND(SUM(sales.vat_amount),2),2) vat_amount,
    			   TRUNCATE(ROUND(SUM(sales.collective_discount_amount),2),2) collective_discount_amount,
				   TRUNCATE(ROUND(SUM(sales.total_invoice),2),2) total_invoice
    			';
    	}
    	 
    	$prepare = \DB::table(\DB::raw('('.$querySales.' UNION '.$queryReturns.') sales'))
    					->selectRaw($select);
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code',
    			function($self, $model){
    				return $model->where('sales.salesman_code','=',$self->getValue());
    			});
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('sales.area_code','=',$self->getValue());
    			});
    	 
    	$companyCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('sales.customer_code','like',$self->getValue().'%');
    			});
    	 
    	$invoiceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('sales.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer',
    			function($self, $model){
    				return $model->where('sales.customer_code','=',$self->getValue());    				
    			});    	    	
    	 
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('sales.item_code','=',$self->getValue());
    			});
    	 
    	$segmentCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code',
    			function($self, $model){
    				return $model->where('sales.segment_code','=',$self->getValue());
    			});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'return_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_posting_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('sales.area_code',$codes);    		
    	}
    	
    	if($this->isSalesman())
    	{
    		$prepare->where('sales.salesman_code',auth()->user()->salesman_code);
    	}
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('sales.invoice_date','desc');
    		$prepare->orderBy('sales.invoice_number');
    	}
    	
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
		$data['records'] = $this->validateInvoiceNumber($result->items());
    	
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
    	$querySales = '
    			SELECT
				all_so.so_number,
    			tas.reference_num,
				tas.activity_code,
				all_so.customer_code,
				ac.customer_name,
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
			    all_so.van_code,
				all_so.device_code,
				all_so.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
				all_so.invoice_number,
				all_so.so_date invoice_date,
				all_so.sfa_modified_date invoice_posting_date,				   
				TRUNCATE(ROUND(coalesce(all_so.gross_served_amount,0.00),2),2) gross_served_amount,
    			TRUNCATE(ROUND(coalesce(all_so.vat_amount,0.00),2),2) vat_amount,
				CONCAT(TRUNCATE(coalesce(all_so.discount_rate,0.00),0),\'%\') discount_rate,
    			TRUNCATE(ROUND(coalesce(all_so.discount_amount,0.00),2),2) discount_amount,
			    CONCAT(TRUNCATE(coalesce(all_so.collective_discount_rate,0.00),0),\'%\') collective_discount_rate,
    			TRUNCATE(ROUND(coalesce(all_so.collective_discount_amount,0.00),2),2) collective_discount_amount,				    
			    all_so.discount_reference_num,
			    all_so.discount_remarks,			    	
    			TRUNCATE(coalesce(all_so.total_sales,0.00),2) total_invoice,
				IF(all_so.updated =\'modified\',\'modified\',\'\') updated,
			
				\'txn_sales_order_header\' invoice_table,
				\'invoice_number\' invoice_number_column,
				\'so_date\' invoice_date_column,
				\'sfa_modified_date\' invoice_posting_date_column,
    			all_so.sales_order_header_id invoice_pk_id,
				\'\' condition_code_table,
				\'\' condition_code_column,
				0 condition_code_pk_id
			
			
				FROM 
    			(
    				 -- For SO Regular Skus --
						 select 
    							tsoh.sales_order_header_id,
    							tsoh.so_number, 
								tsoh.reference_num,
    							tsoh.customer_code, 
								tsoh.salesman_code, 
				    			tsoh.van_code,
								tsoh.device_code,				
								tsoh.sfa_modified_date,
								tsoh.invoice_number,    							
    							tsoh.so_date,    			
    							SUM(tsod.gross_served_amount) gross_served_amount,
								SUM(tsod.vat_amount) vat_amount,
								SUM(tsod.discount_rate) discount_rate,
								SUM(tsod.discount_amount) discount_amount,
    							tsohd.served_deduction_rate collective_discount_rate,
    							SUM(coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) collective_discount_amount,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,
                                SUM( coalesce( (tsod.gross_served_amount + tsod.vat_amount),0.00 ) - (discount_amount + coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) ) total_sales,
    							IF(SUM(tsoh.updated_by),\'modified\', IF(SUM(tsod.updated_by),\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_detail tsod
								on tsoh.reference_num = tsod.reference_num
								and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
    							left join (
    								select 
    									reference_num,
    									served_deduction_rate,
			    						ref_no,
			    						remarks, 
    									sum(coalesce(served_deduction_amount,0)) served_deduction_amount
										from txn_sales_order_header_discount
    									where deduction_code <> \'EWT\' 
										group by reference_num
    							) tsohd on tsoh.reference_num = tsohd.reference_num
    							group by tsoh.so_number 
								

							union all

							-- For SO Deals --
								select
    							tsoh.sales_order_header_id,
    							tsoh.so_number, 
								tsoh.reference_num,
    							tsoh.customer_code, 
								tsoh.salesman_code, 
				    			tsoh.van_code,
								tsoh.device_code,				
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
    							tsoh.so_date,    			
    							SUM(tsodeal.gross_served_amount) gross_served_amount,
								SUM(tsodeal.vat_served_amount) vat_amount,
								0.00 discount_rate,
								0.00 discount_amount,  
    							tsohd.served_deduction_rate collective_discount_rate,
    							SUM(coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) collective_discount_amount,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,  			
								SUM(coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)-coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) total_sales,
    							IF(SUM(tsoh.updated_by),\'modified\', IF(SUM(tsodeal.updated_by),\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_deal tsodeal
								on tsoh.reference_num = tsodeal.reference_num
    							left join (
    								select 
    									reference_num,
    									served_deduction_rate,
			    						ref_no,
			    						remarks, 
    									sum(coalesce(served_deduction_amount,0)) served_deduction_amount
										from txn_sales_order_header_discount
    									where deduction_code <> \'EWT\'
										group by reference_num
    							) tsohd on tsoh.reference_num = tsohd.reference_num
    							group by tsoh.so_number
								
    			) all_so
				LEFT JOIN app_customer ac ON(ac.customer_code=all_so.customer_code)
				LEFT JOIN app_area aa ON(ac.area_code=aa.area_code)
				LEFT JOIN app_salesman aps ON(aps.salesman_code=all_so.salesman_code)
				LEFT JOIN txn_activity_salesman tas ON(tas.reference_num=all_so.reference_num AND tas.salesman_code=all_so.salesman_code)
    			LEFT JOIN (
    				select reference_num,remarks from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    			) remarks ON(remarks.reference_num = tas.reference_num)				
				';
    	
    	$queryReturns = '
    			SELECT
				trh.return_txn_number so_number,
    			trh.reference_num,
				tas.activity_code,
				trh.customer_code,
				ac.customer_name,
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
				trh.van_code,
				trh.device_code,
				trh.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
				trh.return_slip_num invoice_number,
				trh.return_date invoice_date,
				trh.sfa_modified_date invoice_posting_date,				
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.gross_amount,0.00)),2),2)) gross_served_amount,
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.vat_amount,0.00)),2),2)) vat_amount,
				CONCAT(0,\'%\') discount_rate,
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.discount_amount,0.00)),2),2)) discount_amount,
				CONCAT(TRUNCATE(coalesce(trhd.deduction_rate,0.00),0),\'%\') collective_discount_rate,    			    			
			    (-1 * TRUNCATE(ROUND(coalesce(trhd.served_deduction_amount,0.00),2),2)) collective_discount_amount,
			    trhd.ref_no discount_reference_num,
			    trhd.remarks discount_remarks,				
			    (-1 * TRUNCATE(ROUND((SUM((coalesce(trd.gross_amount,0.00) + coalesce(trd.vat_amount,0.00)) - coalesce(trd.discount_amount,0.00)) - coalesce(trhd.served_deduction_amount,0.00)),2),2)) total_invoice,
			    IF(SUM(trh.updated_by),\'modified\',IF(SUM(trd.updated_by),\'modified\',\'\')) updated,
			
			    \'txn_return_header\' invoice_table,
				\'return_slip_num\' invoice_number_column,
				\'return_date\' invoice_date_column,
				\'sfa_modified_date\' invoice_posting_date_column,
    			trh.return_header_id invoice_pk_id,
				\'txn_return_detail\' condition_code_table,
				\'condition_code\' condition_code_column,
				trd.return_detail_id condition_code_pk_id
			
    		FROM txn_return_header trh
			LEFT JOIN app_customer ac ON(ac.customer_code=trh.customer_code)
			LEFT JOIN app_area aa ON(aa.area_code=ac.area_code)
			LEFT JOIN app_salesman aps ON(aps.salesman_code=trh.salesman_code)
			LEFT JOIN txn_activity_salesman tas ON(tas.salesman_code=trh.salesman_code AND tas.reference_num=trh.reference_num)
			LEFT JOIN txn_return_detail trd ON(trh.reference_num=trd.reference_num)
			LEFT JOIN app_item_master aim ON(aim.item_code=trd.item_code)			
    		LEFT JOIN 
    		(
    			select 
    				reference_num,
			    	ref_no,
			    	remarks, 
    				deduction_rate,
    				sum(coalesce(deduction_amount,0)) served_deduction_amount
					from  txn_return_header_discount
    				where deduction_code  <> \'EWT\'
					group by reference_num
    		) trhd ON(trhd.reference_num=trh.reference_num)

    		LEFT JOIN (
    				select reference_num,remarks from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    		) remarks ON(remarks.reference_num = trh.reference_num)

    		GROUP BY trh.return_txn_number
				';
    	
    	$select = '
    			sales.so_number,
    			sales.reference_num,
				sales.activity_code,
				sales.customer_code,
				sales.customer_name,
    			sales.customer_address,
    			sales.remarks,
			    sales.van_code,
				sales.device_code,
				sales.salesman_code,
				sales.salesman_name,
				sales.area,
				sales.invoice_number,
				sales.invoice_date,
				sales.invoice_posting_date,
				sales.gross_served_amount,
				sales.vat_amount,
				sales.discount_rate,
				sales.discount_amount,
			    sales.collective_discount_rate,	
			    sales.collective_discount_amount,
			    sales.discount_reference_num,
			    sales.discount_remarks,			    	
			    sales.total_invoice,
				sales.updated,
				sales.invoice_table,
				sales.invoice_number_column,
				sales.invoice_date_column,
				sales.invoice_posting_date_column,
    			sales.invoice_pk_id,
				sales.condition_code_table,
				sales.condition_code_column,
				sales.condition_code_pk_id   		
    			';
    	 
    	if($summary)
    	{
    		$select = '
    			   TRUNCATE(ROUND(SUM(sales.gross_served_amount),2),2) gross_served_amount,
    			   TRUNCATE(ROUND(SUM(sales.discount_amount),2),2) discount_amount,
				   TRUNCATE(ROUND(SUM(sales.vat_amount),2),2) vat_amount,
    			   TRUNCATE(ROUND(SUM(sales.collective_discount_amount),2),2) collective_discount_amount,
				   TRUNCATE(ROUND(SUM(sales.total_invoice),2),2) total_invoice
    			';
    	}
    	
    	$prepare = \DB::table(\DB::raw('('.$querySales.' UNION '.$queryReturns.') sales'))
			    	->selectRaw($select);			    	

		$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code',
    			function($self, $model){
    				return $model->where('sales.salesman_code','=',$self->getValue());
    			});
			    	
		$areaFilter = FilterFactory::getInstance('Select');
		$prepare = $areaFilter->addFilter($prepare,'area',
			    			function($self, $model){
			    				return $model->where('sales.area_code','=',$self->getValue());
			    			});
			    	 
		$companyCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
							function($self, $model){								
								return $model->where('sales.customer_code','like',$self->getValue().'%');
							});
			    	 
		$invoiceNumFilter = FilterFactory::getInstance('Text');
		$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
						function($self, $model){
							return $model->where('sales.invoice_number','LIKE','%'.$self->getValue().'%');							
					});
		
		$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer',
    			function($self, $model){
    				return $model->where('sales.customer_code','=',$self->getValue());    				
    			});
			    	 
		$itemCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
			    			function($self, $model){
			    				return $model->where('sales.item_code','=',$self->getValue());
			    			});
			    	 
		$segmentCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $segmentCodeFilter->addFilter($prepare,'segment_code',
			    			function($self, $model){
			    				return $model->where('sales.segment_code','=',$self->getValue());
			    			});
			    	
		$invoiceDateFilter = FilterFactory::getInstance('DateRange');
		$prepare = $invoiceDateFilter->addFilter($prepare,'return_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_date)'),$self->formatValues($self->getValue()));
			    			});
			    	
		$postingFilter = FilterFactory::getInstance('DateRange');
		$prepare = $postingFilter->addFilter($prepare,'posting_date',
			    			function($self, $model){
			    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_posting_date)'),$self->formatValues($self->getValue()));
			    			});

        $prepare->orderBy('sales.invoice_date', 'desc');

		if(!$this->hasAdminRole() && auth()->user())
		{
			$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
			$prepare->whereIn('sales.area_code',$codes);
		}
		
		if($this->isSalesman())
		{
			$prepare->where('sales.salesman_code',auth()->user()->salesman_code);
		}
		
		if(!$this->request->has('sort'))
		{
			$prepare->orderBy('sales.invoice_date','desc');
			$prepare->orderBy('sales.invoice_number');
		}
		
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
    		/* $prepare = $this->getPreparedReturnMaterial(true);
    		$summary1 = $prepare->first();
    		$prepare = $this->getPreparedReturnMaterial(false,true);
    		$summary2 = $prepare->first();
    		$data['summary'] = array_merge((array)$summary1,(array)$summary2); */
    		
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
    public function getPreparedReturnMaterial($summary=false,$summaryCollectiveAmount=0)
    {
        $selectTotalInvoice = '(
        						coalesce((txn_return_detail.gross_amount + txn_return_detail.vat_amount),0.00)
        						 - coalesce((txn_return_detail.discount_amount 
        							 + (coalesce((txn_return_detail.gross_amount + txn_return_detail.vat_amount),0.00)
        									*(trhd.collective_discount_rate/100)
        								)
        							),0.00)
        						)';
    	$selectCollectiveDiscountAmount = 'TRUNCATE(ROUND(coalesce((coalesce((txn_return_detail.gross_amount + txn_return_detail.vat_amount),0.00)*(trhd.collective_discount_rate/100)),0.00),2),2)';

        $select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
        		IF(app_customer.address_1=\'\',
	    				IF(app_customer.address_2=\'\',app_customer.address_3,
	    					IF(app_customer.address_3=\'\',app_customer.address_2,CONCAT(app_customer.address_2,\', \',app_customer.address_3))
	    					),
	    				IF(app_customer.address_2=\'\',
	    					IF(app_customer.address_3=\'\',app_customer.address_1,CONCAT(app_customer.address_1,\', \',app_customer.address_3)),
	    					  IF(app_customer.address_3=\'\',
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2),
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2,\', \',app_customer.address_3)
	    						)
	    					)
	    		  ) customer_address,
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
				CONCAT(\'0\',\'%\') discount_rate,
				txn_return_detail.discount_amount,
				CONCAT(TRUNCATE(coalesce(trhd.collective_discount_rate,0.00),0),\'%\') collective_discount_rate,	
    			'.$selectCollectiveDiscountAmount.' collective_discount_amount,
      			trhd.discount_reference_num,
    			trhd.discount_remarks,
    			TRUNCATE(ROUND('.$selectTotalInvoice.',2),2) total_invoice,
    			IF(txn_return_header.updated_by,\'modified\',
	    					IF(txn_return_detail.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)

	    		) updated 
    			';
    	 
    	if($summary)
    	{
    		$select = '
    			SUM(txn_return_detail.quantity) quantity,
				SUM(txn_return_detail.gross_amount) gross_amount,
				SUM(txn_return_detail.vat_amount) vat_amount,
				SUM('.$selectCollectiveDiscountAmount.') collective_discount_amount,
    			SUM(TRUNCATE(ROUND('.$selectTotalInvoice.',2),2)) total_invoice';
    	}
    	elseif($summaryCollectiveAmount)
    	{
    		$select = ' coalesce(trhd.collective_discount_amount,0.00) collective_discount_amount';
    	}
    	
    	$prepare = \DB::table('txn_return_header')
			    	->selectRaw($select)
			    	->join('txn_activity_salesman', function($join){
			    		$join->on('txn_return_header.reference_num','=','txn_activity_salesman.reference_num');
			    		$join->on('txn_return_header.salesman_code','=','txn_activity_salesman.salesman_code');
			    	})
			    	->leftJoin('txn_return_detail','txn_return_header.reference_num','=','txn_return_detail.reference_num')			    	
			    	->leftJoin('app_customer','txn_return_header.customer_code','=','app_customer.customer_code')
			    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
			    	->leftJoin('app_salesman','txn_return_header.salesman_code','=','app_salesman.salesman_code')			    	
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
					return $model->where('txn_return_header.return_slip_num','LIKE','%'.$self->getValue().'%');
				});
		
		$itemCodeFilter = FilterFactory::getInstance('Select');
		$prepare = $itemCodeFilter->addFilter($prepare,'material',
			    			function($self, $model){
			    				return $model->where('app_item_master.item_code','=',$self->getValue());
			    			});
		$customerFilter = FilterFactory::getInstance('Select');
		$prepare = $customerFilter->addFilter($prepare,'customer',
				function($self, $model){
					return $model->where('txn_return_header.customer_code','=',$self->getValue());
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
		
		
		$prepare->where('txn_activity_salesman.activity_code','LIKE','%R%');
		
		if($summaryCollectiveAmount)
		{
			$prepare->groupBy('txn_return_header.reference_num');
		}
		
		if(!$this->hasAdminRole() && auth()->user())
		{
			$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
			$prepare->whereIn('app_area.area_code',$codes);
		}

		if($this->isSalesman())
		{
			$prepare->where('txn_return_header.salesman_code',auth()->user()->salesman_code);	
		}
		
		if(!$this->request->has('sort'))
		{
			$prepare->orderBy('txn_return_header.return_date','desc');
		}
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
        $selectTotalInvoice = '(
        						 coalesce((trd.gross_amount + trd.vat_amount),0.00)
        						 - (trd.discount_amount + coalesce(trhd.collective_discount_amount,0.00))
        						) total_invoice';

    	$select = '
    			txn_return_header.return_txn_number,
				txn_return_header.reference_num,
				txn_activity_salesman.activity_code,
				txn_return_header.customer_code,
				app_customer.customer_name,
    			IF(app_customer.address_1=\'\',
	    				IF(app_customer.address_2=\'\',app_customer.address_3,
	    					IF(app_customer.address_3=\'\',app_customer.address_2,CONCAT(app_customer.address_2,\', \',app_customer.address_3))
	    					),
	    				IF(app_customer.address_2=\'\',
	    					IF(app_customer.address_3=\'\',app_customer.address_1,CONCAT(app_customer.address_1,\', \',app_customer.address_3)),
	    					  IF(app_customer.address_3=\'\',
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2),
	    							CONCAT(app_customer.address_1,\', \',app_customer.address_2,\', \',app_customer.address_3)
	    						)
	    					)
	    		  ) customer_address,
				remarks.remarks,
			    txn_return_header.van_code,
			    txn_return_header.device_code,
				txn_return_header.salesman_code,
				app_salesman.salesman_name,
				app_area.area_name area,
				txn_return_header.return_slip_num,
				txn_return_header.return_date,
				txn_return_header.sfa_modified_date return_posting_date,
				trd.gross_amount,
				trd.vat_amount,
				CONCAT(\'0\',\'%\') discount_rate,
				trd.discount_amount,
				CONCAT(TRUNCATE(coalesce(trhd.collective_discount_rate,0.00),0),\'%\') collective_discount_rate,	
    			coalesce(trhd.collective_discount_amount,0.00) collective_discount_amount,
      			trhd.discount_reference_num,
    			trhd.discount_remarks,
    			'.$selectTotalInvoice.',
	    		IF(txn_return_header.updated_by,\'modified\',
	    					IF(trd.updated_by,\'modified\',
    							IF(remarks.updated_by,\'modified\',\'\')
    						)

	    		) updated
    			';

    	if($summary)
    	{
    		$select = '
    			SUM(trd.gross_amount) gross_amount,
				SUM(trd.vat_amount) vat_amount,
				SUM(trd.discount_amount) discount_amount,
				SUM(trhd.collective_discount_amount) collective_discount_amount,
    			SUM(trhd.collective_deduction_amount) collective_deduction_amount,
				SUM'.$selectTotalInvoice;
    	}
    	
    	$prepare = \DB::table('txn_return_header')
			    	->selectRaw($select)
			    	->join('txn_activity_salesman', function($join){
			    		$join->on('txn_return_header.reference_num','=','txn_activity_salesman.reference_num');
			    		$join->on('txn_return_header.salesman_code','=','txn_activity_salesman.salesman_code');
			    	})
			    	->leftJoin('app_customer','txn_return_header.customer_code','=','app_customer.customer_code')
			    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code')
			    	->leftJoin('app_salesman','txn_return_header.salesman_code','=','app_salesman.salesman_code')			    	
			    	->leftJoin(\DB::raw('(
						    	select return_detail_id,
			    				   updated_by,
			    				   reference_num,
								   sum(gross_amount) as gross_amount,
			    				   sum(vat_amount) as vat_amount,
			    				   0 as discount_rate,
			    				   sum(discount_amount) as discount_amount									
								from txn_return_detail group by reference_num
			    			   ) trd'), function($join){
			    				$join->on('txn_return_header.reference_num','=','trd.reference_num');
			    	})
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
					return $model->where('txn_return_header.return_slip_num','LIKE','%'.$self->getValue().'%');
				});

		$customerFilter = FilterFactory::getInstance('Select');
		$prepare = $customerFilter->addFilter($prepare,'customer',
				function($self, $model){
					return $model->where('txn_return_header.customer_code','=',$self->getValue());
				});
		
		
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'return_date');
    	
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(txn_return_header.sfa_modified_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	$prepare->where('txn_activity_salesman.activity_code','LIKE','%R%');
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_area.area_code',$codes);
    	}
    	
    	if($this->isSalesman())
    	{
    		$prepare->where('txn_return_header.salesman_code',auth()->user()->salesman_code);
    	}
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('txn_return_header.return_date','desc');
    	}
    	
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
    			IF(app_customer.address_1=\'\',
    				IF(app_customer.address_2=\'\',app_customer.address_3,
    					IF(app_customer.address_3=\'\',app_customer.address_2,CONCAT(app_customer.address_2,\', \',app_customer.address_3))
    					),
    				IF(app_customer.address_2=\'\',
    					IF(app_customer.address_3=\'\',app_customer.address_1,CONCAT(app_customer.address_1,\', \',app_customer.address_3)),
    					  IF(app_customer.address_3=\'\',
    							CONCAT(app_customer.address_1,\', \',app_customer.address_2),
    							CONCAT(app_customer.address_1,\', \',app_customer.address_2,\', \',app_customer.address_3)
    						)
    					)
    			) address,
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

        $customerNameFilter = FilterFactory::getInstance('Select');
        $prepare = $customerNameFilter->addFilter($prepare,'customer_name',
                            function($self, $model){
                                return $model->where('app_customer.customer_name','like','%'.$self->getValue().'%');
                            });
        $customerPriceGroupFilter = FilterFactory::getInstance('Select');
        $prepare = $customerPriceGroupFilter->addFilter($prepare,'customer_price_group',
                            function($self, $model){
                                return $model->where('app_customer.customer_price_group','=', $self->getValue());
                            });
    	 
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');

    	if($this->isSalesman())
			$prepare->where('app_salesman.salesman_code',auth()->user()->salesman_code);

    	$prepare->where('app_salesman_customer.status','=','A');
    	$prepare->where('app_area.status','=','A');
    	$prepare->where('app_salesman.status','=','A');
    	$prepare->where('app_salesman_van.status','=','A');
    	 
    	$prepare->groupBy('app_customer.customer_code');
    	$prepare->groupBy('app_customer.customer_name');
    	$prepare->groupBy('app_customer.address_1');
    	$prepare->groupBy('app_customer.area_code');
    	$prepare->groupBy('app_area.area_name');
    	$prepare->groupBy('app_customer.storetype_code');
    	$prepare->groupBy('app_storetype.storetype_name');
    	$prepare->groupBy('app_customer.vatposting_code');
    	$prepare->groupBy('app_customer.vat_ex_flag');
    	$prepare->groupBy('app_customer.customer_price_group');
    	$prepare->groupBy('app_salesman_customer.salesman_code');
    	$prepare->groupBy('app_salesman.salesman_name');    	
    	$prepare->groupBy('app_salesman_van.van_code');
    	$prepare->groupBy('app_customer.sfa_modified_date');
    	$prepare->groupBy('app_customer.status');
    	
    	$prepare->groupBy('app_salesman_van.van_code');
    	 
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_area.area_code',$codes);
    	}
    	
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
     * Get salesman area codes
     * @param unknown $salesmanCode
     */
    public function getSalesmanArea($salesmanCode)
    {
    	$select = 'app_area.area_code';
    	
    	$prepare = \DB::table('app_salesman')
				    	->distinct()
				    	->selectRaw($select)
				    	->leftJoin('app_salesman_customer','app_salesman_customer.salesman_code','=','app_salesman.salesman_code')
				    	->leftJoin('app_customer','app_customer.customer_code','=','app_salesman_customer.customer_code')
				    	->leftJoin('app_area','app_area.area_code','=','app_customer.area_code');
    	
		$prepare->where('app_salesman.salesman_code',$salesmanCode);
    	
    	return $prepare->lists('area_code');	
    }
    
    
    /**
     * Get salesman area codes
     * @param unknown $salesmanCode
     */
    public function getRdsSalesmanArea()
    {    	
    	return ModelFactory::getInstance('RdsSalesman')->orderBy('area_name')->lists('area_name','area_name');
    }
    
    /**
     * Return Salesman List prepared statement
     * @return unknown
     */
    public function getPreparedSalesmanList($salesman='')
    {
    	$select = '
    			app_salesman.salesman_code,
    			app_salesman.salesman_name,
    			app_area.area_code,
				app_area.area_name,
    			app_salesman_van.van_code,
    			app_salesman.sfa_modified_date,
				IF(app_salesman.status=\'A\' && app_salesman_van.status=\'A\',
    				\'Active\',IF(app_salesman.status=\'I\' || app_salesman_van.status=\'I\',\'Inactive\',\'Deleted\')) status
    			';
    	 
    	$prepare = \DB::table('app_salesman')
    			->distinct()
		    	->selectRaw($select)		    	
		    	->leftJoin('app_salesman_customer','app_salesman_customer.salesman_code','=','app_salesman.salesman_code')
		    	->leftJoin('app_customer','app_customer.customer_code','=','app_salesman_customer.customer_code')
		    	->leftJoin('app_area','app_area.area_code','=','app_customer.area_code')
		    	->leftJoin('app_salesman_van','app_salesman_van.salesman_code','=','app_salesman.salesman_code');
		    	
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
								return $model->where('app_customer.customer_code','like',$self->getValue().'%');
							});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date');
    	
    	if($this->isSalesman())
    		$prepare->where('app_salesman.salesman_code',auth()->user()->salesman_code);
    	
    	$prepare->where('app_salesman_customer.status','=','A');
    	$prepare->where('app_customer.status','=','A');
    	$prepare->where('app_area.status','=','A');
    	
    	if($status = $this->request->get('status'))
    	{
    		if($status == 'A')
    			$prepare->where(function($query){
    				$query->where('app_salesman.status','A');
    				$query->where('app_salesman_van.status','A');
    			});
    		elseif($status == 'I')
    			$prepare->where(function($query){
    				$query->where('app_salesman.status','I');
    				$query->OrWhere('app_salesman_van.status','I');
    			});
			else
    			$prepare->where(function($query){
    				$query->where('app_salesman.status','D');
    				$query->where('app_salesman_van.status','D');
    			});
    	}    	
    	
    	$prepare->groupBy('app_salesman.salesman_code');
    	$prepare->groupBy('app_salesman.salesman_name');
    	$prepare->groupBy('app_area.area_code');
    	$prepare->groupBy('app_salesman_van.van_code');
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_customer.area_code',$codes);
    	}
    	
    	if($salesman)
    	{
    		$prepare->where('app_salesman.salesman_code','=',$salesman);
    	}
    	
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
    			app_item_price.uom_code,
				app_item_master.segment_code,
    			app_item_price.unit_price,
    			app_item_price.customer_price_group,
    			app_item_price.effective_date_from,
    			app_item_price.effective_date_to,
    			app_area.area_name,
    			app_item_master.sfa_modified_date,
				IF(app_item_master.status=\'A\',\'Active\',IF(app_item_master.status=\'I\',\'Inactive\',\'Deleted\')) status
    			';
    	
    	$prepare = \DB::table('app_item_price')
    				->selectRaw($select)
    				->join('app_item_master','app_item_master.item_code','=','app_item_price.item_code')
    				->join('app_customer','app_customer.customer_price_group','=','app_item_price.customer_price_group')
			    	->join('app_area','app_customer.area_code','=','app_area.area_code');

		$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
    	
    	$itemFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemFilter->addFilter($prepare,'item_code');
    	
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
    	$prepare = $invoiceDateFilter->addFilter($prepare,'sfa_modified_date',function($self, $model){    		    						
								return $model->whereBetween('app_item_master.sfa_modified_date',$self->formatValues($self->getValue()));
							});
    	
    	$effectiveDateFromFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $effectiveDateFromFilter->addFilter($prepare,'effective_date1',
							function($self, $model){
								return $model->whereBetween('app_item_price.effective_date_from',$self->formatValues($self->getValue()));
							});
    	
    	$effectiveDateToFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $effectiveDateToFilter->addFilter($prepare,'effective_date2',
							function($self, $model){
								return $model->whereBetween('app_item_price.effective_date_to',$self->formatValues($self->getValue()));
							});
    	
    	$segmentFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentFilter->addFilter($prepare,'segment_code',
    			function($self, $model){
    				return $model->where('app_item_master.segment_code','=',$self->getValue());
    			});
    	
    	$prepare->where('app_item_price.status','=','A');
    	$prepare->where('app_item_master.status','=','A');
    	$prepare->where('app_customer.status','=','A');
    	$prepare->where('app_area.status','=','A');
    	 
    	$prepare->groupBy('app_item_price.item_code');
    	$prepare->groupBy('app_item_master.description');
    	$prepare->groupBy('app_item_price.uom_code');
    	$prepare->groupBy('app_item_master.segment_code');
    	$prepare->groupBy('app_item_price.unit_price');
    	$prepare->groupBy('app_item_price.customer_price_group');
    	$prepare->groupBy('app_item_price.effective_date_from');
    	$prepare->groupBy('app_item_price.effective_date_to');
    	$prepare->groupBy('app_area.area_name');
    	$prepare->groupBy('app_item_price.sfa_modified_date');
    	$prepare->groupBy('app_item_price.status');
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_area.area_code',$codes);
    	}
    	return $prepare;
    }
    
    /**
     * Get Table Column Headers
     * @param unknown $type
     * @param unknown $export
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableColumns($type='',$export='')    
    {
    	switch($type)
    	{
    		case 'salescollectionreport':
    			return $this->getSalesCollectionReportColumns($export);    			
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
			case 'summaryofincidentsreport':
				return PresenterFactory::getInstance('User')->getIncidentReportTableColumns();
			case 'stocktransfer':
				return PresenterFactory::getInstance('VanInventory')->getStockTransferColumns();
			case 'stockaudit':
				return PresenterFactory::getInstance('VanInventory')->getStockAuditColumns();
			case 'flexideal':
				return PresenterFactory::getInstance('VanInventory')->getFlexiDealColumns();
			case 'invoiceseries':
				return PresenterFactory::getInstance('Invoice')->getInvoiceSeriesColumns(true);
    	}	
    }
    
    /**
     * Get Sales Collection Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionReportColumns($export='')    
    {    
    	$headers = [
    			['name'=>'Customer Code'],
    			['name'=>'Customer Name'],
    			['name'=>'Customer Address'],
                ['name'=>'Remarks'],
    			['name'=>'Invoice Number'],
    			['name'=>'Invoice Date'],
    			['name'=>'Invoice Gross Amount'],
    			['name'=>'Invoice Discount Amount Per Item'],
    			['name'=>'Invoice Discount Amount Collective'],
    			['name'=>'Invoice Net Amount'],
    			['name'=>'CM Number'],
    			['name'=>'Other Deduction Amount'],
    			['name'=>'Return Slip Number'],
    			['name'=>'Return Amount'],
    			['name'=>'Return Discount Amount'],
    			['name'=>'Return Net Amount'],
    			['name'=>'Invoice Collectible Amount'],
    			['name'=>'Collection Date'],
    			['name'=>'OR Number'],
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
    	
    	if($export == 'pdf')
    		unset($headers[5],$headers[6],$headers[7],$headers[12],$headers[13]);
    	
    	return $headers;
    }
    
    
    /**
     * Get Sales Collection Posting Table Headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesCollectionPostingColumns()
    {
    	$headers = [
    			['name'=>'Activity Code'],
    			['name'=>'Salesman Name'],
    			['name'=>'Customer Code'],
    			['name'=>'Customer Name'],
    			['name'=>'Remarks'],
    			['name'=>'Invoice Number'],
    			['name'=>'Invoice Collectible Amount'],
    			['name'=>'Invoice Date'],
    			['name'=>'Invoice Posting Date'],
    			['name'=>'OR Number'],
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
    			['name'=>'Customer Address'],
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
    			['name'=>'Invoice Date'],
    			['name'=>'Invoice No.'],    			 
    			['name'=>'Return Slip No.'],
    			['name'=>'Transaction Date'],
    			['name'=>'Stock Transfer No.'],
    			['name'=>'Replenishment Date'],
    			['name'=>'Replenishment Number']
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
    			['name'=>'Document Date','sort'=>'document_date'],
    			['name'=>'Name','sort'=>'name'],
    			['name'=>'Customer Address'],
    			['name'=>'Depot','sort'=>'depot'],
    			['name'=>'Reference','sort'=>'reference'],
    			['name'=>'VAT Registration No.'],
    			['name'=>'Sales-Exempt'],
    			['name'=>'Sales-12%'],
    			['name'=>'Sales-0%'],  			
    			['name'=>'Total Sales'],
    			['name'=>'Tax Amount'],
    			['name'=>'Total Invoice Amount'],
    			['name'=>'Local Sales'],
    			['name'=>'Services'],    			 
    			['name'=>'Term-Cash'],
    			['name'=>'Term-on-Account'],
    			['name'=>'Sales Group','sort'=>'sales_group'],
    			['name'=>'Assignment','sort'=>'assignment'],
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
    			['name'=>'Customer Address'],
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
    			['name'=>'Taxable Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item','sort'=>'discount_amount'],
    			['name'=>'Collective Discount Rate'],
    			['name'=>'Collective Discount Amount','sort'=>'collective_discount_amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],    			
    			['name'=>'Total Sales'],
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
    			['name'=>'Customer Address'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Invoice No/ Return Slip No.','sort'=>'invoice_number'],
    			['name'=>'Invoice Date/ Return Date','sort'=>'invoice_date'],
    			['name'=>'Invoice/Return Posting Date','sort'=>'invoice_posting_date'],
    			['name'=>'Taxable Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate' ,'sort'=>'collective_discount_rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],    			
    			['name'=>'Total Sales'],
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
    			['name'=>'Customer Address'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Return Slip No.','sort'=>'return_slip_num'],
    			['name'=>'Return Date','sort'=>'return_date'],
    			['name'=>'Return Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Segment Code','sort'=>'segment_code'],
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Condition Code','sort'=>'condition_code'],
                ['name'=>'Quantity','sort'=>'quantity'],
    			['name'=>'Uom Code'],
    			['name'=>'Taxable Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate','sort'=>'collective_discount_rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Return Net Amount'],
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
    			['name'=>'Customer Address'],
    			['name'=>'Remarks','sort'=>'remarks'],
    			['name'=>'Van Code','sort'=>'van_code'],
    			['name'=>'Device Code','sort'=>'device_code'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'Return Slip No.','sort'=>'return_slip_num'],
    			['name'=>'Return Date','sort'=>'return_date'],
    			['name'=>'Posting Date','sort'=>'return_posting_date'],
    			['name'=>'Taxable Amount'],
    			['name'=>'Vat Amount'],
    			['name'=>'Discount Rate Per Item','sort'=>'discount_rate'],
    			['name'=>'Discount Amount Per Item'],
    			['name'=>'Collective Discount Rate','sort'=>'collective_discount_rate'],
    			['name'=>'Collective Discount Amount'],
    			['name'=>'Reference No.','sort'=>'discount_reference_num'],
    			['name'=>'Remarks'],
    			['name'=>'Total Return Net Amount'],
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
    public function getSalesman($withCode=true, $strictSalesman=true)
    {
    	$select = 'app_salesman.salesman_code, app_salesman.salesman_name name';
    	if($withCode)
    	{
    		$select = 'app_salesman.salesman_code, CONCAT(app_salesman.salesman_code,\' - \',app_salesman.salesman_name) name';
    	}
    	
    	$prepare = \DB::table('app_salesman')
    					->distinct()
	    				->selectRaw($select)
	    				->leftJoin('app_salesman_customer','app_salesman.salesman_code','=','app_salesman_customer.salesman_code')
	    				->leftJoin('app_customer','app_customer.customer_code','=','app_salesman_customer.customer_code')
	    				->where('app_salesman.status','=','A')
	    				->orderBy('name');
    	
    	if($strictSalesman && $this->isSalesman())
    		$prepare->where('app_salesman.salesman_code',auth()->user()->salesman_code);
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_customer.area_code',$codes);    		
    	}
    		 
    	
    	$salesman = $prepare->lists('name','salesman_code');
    	$user = auth()->user();    	
    	if(!$salesman)
    		$salesman[0] = $user->salesman_code ? $user->salesman_code.'-'.$user->fullname : $user->fullname;
    	return $salesman;
    }

	/**
	 * @return array of auditor's name.
	 */
	public function getAuditor()
	{
		$response = ModelFactory::getInstance('user')->auditor()->get();

		return $response->lists('full_name', 'id');
	}


	/**
	 * Get Customers
	 * @return multitype:
	 */
	public function getCustomer($strictSalesman = true)
	{
		$prepare = ModelFactory::getInstance('AppCustomer')->where('status', '=', 'A')
			->orderBy('customer_name');
		if ($strictSalesman && $this->isSalesman()) {
			$customers = \DB::table('app_salesman_customer')->distinct()
				->select(['salesman_customer_id', 'customer_code'])
				->where('salesman_code', auth()->user()->salesman_code)->lists('customer_code');
			$prepare->whereIn('customer_code', $customers);
		} elseif ($this->isAcounting()) {
			$appArea = ModelFactory::getInstance('AppArea');
			$areaName = $appArea->where('area_code',
				auth()->user()->location_assignment_code)->select('area_name')->first();
			$areaName = explode(" ", $areaName->area_name)[1];
			$areaCodes = $appArea->where('area_name', 'LIKE', '%' . $areaName . '%')->lists('area_code');
			$prepare->whereIn('area_code', $areaCodes);
		}

		return $prepare->lists('customer_name', 'customer_code');
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
     * Get Company Code
     * @return multitype:
     */
    public function getPriceGroup()
    {
    	return \DB::table('app_item_price')
				    	->orderBy('customer_price_group')
				    	->lists('customer_price_group','customer_price_group');
    }
    
	/**
     * Get Area
     * @return multitype:
     */
    public function getArea($sfiOnly=false,$forcePermission=true)
    {
    	$prepare = \DB::table('app_area')
		    			->where('status','=','A');
    	if($sfiOnly)
    	{
    		$prepare->where('area_name','like','SFI%');
    	}
    	
    	if($forcePermission && !$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('app_area.area_code',$codes);    		
    	}
    	return $prepare->orderBy('area_name')->lists('area_name','area_code');
    }

    /**
     * Get Item Lists
     */
    public function getItems($oderByItemCode=false)
    {
    	$prepare = \DB::table('app_item_master')->where('status','=','A');
    	if($oderByItemCode)
    		$prepare->orderBy('item_code');
    	else
    		$prepare->orderBy('description');
    	return $prepare->lists('description','item_code');
    }
    
    /**
     * Get Item Lists
     */
    public function getItemCodes()
    {
    	return \DB::table('app_item_master')
			    	->where('status','=','A')
			    	->orderBy('item_code')
			    	->lists('item_code','item_code');
    }
    
    /**
     * Get Item Segment Codes
     */
    public function getItemSegmentCode()
    {
    	return \DB::table('app_item_segment')
    			->where('status','=','A')
    			->orderBy('segment_code')
    			->lists('segment_code','segment_code');
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
    	
    	ini_set('memory_limit', '-1');
        set_time_limit (0);
    	
    	$records = [];
    	$columns = [];
    	$theadRaw = '';
    	$rows = [];
    	$summary = [];
    	$header = '';
    	$filters = [];
    	$previous = [];
    	$current = [];
    	$currentSummary = [];
    	$previousSummary = [];
    	$filename = 'Report';
    	$scr = '';
    	$area = '';
    	$prepare = '';
    	$fontSize = '12px';
    	$textSize = '12px';
    	$vaninventory = false;
    	$salesSummary = false;
		$summaryOfIncident = false;
    	
    	$limit = in_array($type,['xls','xlsx']) ? config('system.report_limit_xls') : config('system.report_limit_pdf');
    	$offset = ($offset == 1 || !$offset) ? 0 : $offset-1;
    	
    	switch($report)
    	{
    		case 'salescollectionreport':
    			$columns = $this->getTableColumns($report,$type);

    			$prepare = $this->getPreparedSalesCollection();
    			$prepare->orderBy('collection.invoice_date','desc');
    			$collection1 = $prepare->get();
    			
    			$referenceNum = [];
		    	$invoiceNum = [];
		    	foreach($collection1 as $col)
		    	{
		    		$referenceNum[] = $col->reference_num;
		    		$invoiceNum[] = $col->invoice_number;
		    	}
		    	
		    	array_unique($referenceNum);
		    	array_unique($invoiceNum);
		    	$except = $referenceNum ? ' AND tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\') ' : '';
		    	$except .= $invoiceNum ? ' AND coltbl.invoice_number NOT IN(\''.implode("','",$invoiceNum).'\') ' : '';
    			 
    			$prepare = $this->getPreparedSalesCollection2(false,$except);
    			$collection2 = $prepare->get();
    			
    			$collection = array_merge((array)$collection1,(array)$collection2);
    			$current = $this->formatSalesCollection($collection);    			
    			
    			$currentSummary = [];
    			if($current)
    			{
    				$currentSummary = $this->getSalesCollectionTotal($current);
    			}    			
    			
    			$current = array_splice($current, $offset, $limit);    			  		
    			
    			$hasDateFilter = false;
    			if($this->request->has('collection_date_from')) 
    			{
    				$from = new Carbon($this->request->get('collection_date_from'));
    				$endOfWeek = (new Carbon($this->request->get('collection_date_from')))->endOfWeek();
    				$to = new Carbon($this->request->get('collection_date_to'));
    				$hasDateFilter = true;
    			}    			
    			    			
    			if($hasDateFilter && $from->eq($to))
    			{
    				$scr = $this->request->get('salesman').'-'.$from->format('mdY');
    			}
    			elseif($hasDateFilter &&  $from->lt($to) && $to->lte($endOfWeek) && $to->diffInDays($from) < 8)
    			{
    				$golive = new Carbon(config('system.go_live_date'));
    				$numOfWeeks = $to->diffInWeeks($golive) + 1;    				    		
    				$code = str_pad($numOfWeeks,5,'0',STR_PAD_LEFT);
    				$scr = $this->request->get('salesman').'-'.$code;
    			}
    			
    			$prepareArea = $this->getPreparedSalesmanList($this->request->get('salesman'));
    			$resultArea = $prepareArea->first();
    			$area = $resultArea ? $resultArea->area_name : '';
    			    			
    			$pdf = !in_array($type,['xls','xlsx']);
    			$rows = $this->getSalesCollectionSelectColumns($pdf);   
    			$header = 'Sales & Collection Report';
    			$filters = $this->getSalesCollectionFilterData(true);    			
    			$filename = 'Sales & Collection Report';
    			$vaninventory = true;
    			$fontSize = '7px';
    			break;
    		case 'salescollectionposting':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedSalesCollectionPosting();
    			$collection1 = $prepare->get();
    	
		    	$referenceNum = [];
		    	foreach($collection1 as $col)
		    	{
		    		$referenceNum[] = $col->reference_num;
		    	}
    	
    			array_unique($referenceNum);
    			$except = $referenceNum ? ' AND tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\') ' : '';

    			$prepare = $this->getPreparedSalesCollectionPosting2($except);
    			$collection2 = $prepare->get();    	
    			
    			$collection = array_merge((array)$collection1,(array)$collection2);
    			$invoices = [];
    			foreach($collection as $col)
    				$invoices[] = $col->invoice_number;
    			 
    			sort($invoices,SORT_NATURAL);
    			 
    			$records = [];
    			$reference = [];
    			foreach($invoices as $invoice)
    			{
    				foreach($collection as $col)
    				{
    					if(isset($col->invoice_number) && $invoice == $col->invoice_number && !in_array($col->reference_num,$reference))
    					{
    						$records[] = $col;
    						$reference[] = $col->reference_num;
    					}
    				}
    			}
    			
    			$records = array_splice($records, $offset, $limit);
    			
    			$rows = $this->getSalesCollectionPostingSelectColumns();
    			$header = 'Sales & Collection Posting Date';
    			$filters = $this->getSalesCollectionFilterData();
    			$filename = 'Sales & Collection Posting Date Report';
    			$vaninventory = true;
    			break;
    		case 'salescollectionsummary':
    			//$columns = $this->getTableColumns($report);
    			$theadRaw = '
    					<tr>
							<th rowspan="2" align="center">SCR#</th>
							<th colspan="2" align="center">Invoice Number</th>
							<th rowspan="2" align="center">Invoice Date</th>
							<th rowspan="2" align="center" style="wrap-text:true">Total Collected Amount</th>
							<th rowspan="2" align="center" style="wrap-text:true">12% Sales Tax</th>
							<th rowspan="2" align="center" style="wrap-text:true">Amount Subject To Commission</th>
						</tr>
    					<tr>';
    			
    			if(in_array($type,['xls','xlsx']))
					$theadRaw .= '<th align="center"></th>';
							
    			$theadRaw .= '
    						<th align="center">From</th>
							<th align="center">To</th>    						
					    </tr>'; 
    			$prepare = $this->getPreparedSalesCollectionSummary();
    			$rows = $this->getSalesCollectionSummarySelectColumns();
    			$summary = $this->getPreparedSalesCollectionSummary(true)->first();
    			$header = 'Monthly Summary of Sales';
    			$filters = $this->getSalesCollectionSummaryFilterData();
    			$filename = 'Monthly Summary of Sales';
    			$salesSummary = true;
    			break;
    		case 'bir';
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedBir(true);
    			$summary = $this->getPreparedBir(true,true)->first();
    			$rows = $this->getBirSelectColumns();
    			$header = 'BIR Report';
    			$filters = $this->getBirFilterData();
    			$filename = 'BIR Report';
    			break;
    		case 'unpaidinvoice';
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedUnpaidInvoice();
    			$rows = $this->getUnpaidSelectColumns();
    			$summary = $this->getPreparedUnpaidInvoice(true)->first();
    			$header = 'Unpaid Invoice Report';
    			$filters = $this->getUnpaidFilterData();
    			$filename = 'Unpaid Invoice Report';
    			$textSize = '14px';
    			$fontSize = '15px';
    			break;
    		case 'vaninventorycanned';
    			if($type == 'pdf')
    				return PresenterFactory::getInstance('VanInventory')->exportShortageOverages('canned');
    		
    			$vaninventory = true; 				    			
    			$columns = $this->getVanInventoryColumns('canned');
    			
    			$params = $this->request->all();
    			$from = date('Y/m/d', strtotime($params['transaction_date_from']));
    			$to = $params['transaction_date_to'];
    			while(strtotime($from) <= strtotime($to))
    			{
    				$params['transaction_date'] = $from;
    				$this->request->replace($params);
    				$from = date('Y/m/d', strtotime('+1 day', strtotime($from)));
    				$records = array_merge($records,(array)$this->getVanInventory(true, $offset));
    			}
    			    			
	    		$rows = $this->getVanInventorySelectColumns('canned');
	    		$header = 'Canned & Mixes Van Inventory and History Report';
	    		$filters = $this->getVanInventoryFilterData();
	    		$filename = 'Van Inventory and History Report(Canned & Mixes)';
	    		break;
    		case 'vaninventoryfrozen';
    		
    			if($type == 'pdf')
    			return PresenterFactory::getInstance('VanInventory')->exportShortageOverages('frozen');
    		
    			$vaninventory = true;    			
    			$columns = $this->getVanInventoryColumns('frozen');

    			$params = $this->request->all();
    			$from = date('Y/m/d', strtotime($params['transaction_date_from']));
    			$to = $params['transaction_date_to'];
    			while(strtotime($from) <= strtotime($to))
    			{
    				$params['transaction_date'] = $from;
    				$this->request->replace($params);
    				$from = date('Y/m/d', strtotime('+1 day', strtotime($from)));
    				$records = array_merge($records,(array)$this->getVanInventory(true, $offset));
    			}
    			
	    		$rows = $this->getVanInventorySelectColumns('frozen');
	    		$header = 'Frozen & Kassel Van Inventory and History Report';
	    		$filters = $this->getVanInventoryFilterData();
    			$filename = 'Van Inventory and History Report(Frozen & Kassel)';
    			break; 
    		case 'salesreportpermaterial';
    			$columns = $this->getTableColumns($report);
    			$rows = $this->getSalesReportMaterialSelectColumns();
    			
    			$prepare = $this->getPreparedSalesReportMaterial();    			 
    			$summary = $this->getPreparedSalesReportMaterial(true)->first();    			
    			$prepare = $prepare->skip($offset)->take($limit);
    			$records = $prepare->get();
    			
    			$header = 'Sales Report Per Material';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Sales Report Per Material';
    			$fontSize = '7px';
    			break;
    		case 'salesreportperpeso':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedSalesReportPeso();
    			$rows = $this->getSalesReportPesoSelectColumns();
    			$summary = $this->getPreparedSalesReportPeso(true)->first();
    			$header = 'Sales Report Per Peso';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Sales Report Per Peso';
    			$fontSize = '7px';
    			break;
    		case 'returnpermaterial':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedReturnMaterial();
    			$rows = $this->getReturnReportMaterialSelectColumns();
    			$summary = $this->getPreparedReturnMaterial(true)->first();
    			$header = 'Return Per Material';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Return Per Material';
    			$fontSize = '8px';
    			break;
    		case 'returnperpeso':
    			$columns = $this->getTableColumns($report);
    			$prepare = $this->getPreparedReturnPeso();
    			$rows = $this->getReturnReportPesoSelectColumns();
    			$summary = $this->getPreparedReturnPeso(true)->first();
    			$header = 'Return Per Peso';
    			$filters = $this->getSalesReportFilterData($report);
    			$filename = 'Return Per Peso';
    			$fontSize = '10px';
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
			case 'summaryofincidentsreport':
				$columns = $this->getTableColumns($report);
				$prepare = PresenterFactory::getInstance('User')->getPreparedSummaryOfIncidentReportList(false);
				$rows = $this->getSummaryOfIncidentReportSelectColumns();
				$header = 'Summary Of Incident Report';
				$filters = $this->getSummaryOfIncidentReportFilterData();
				$filename = 'Summary Of Incident Report';
				$summaryOfIncident = true;
				break;
				
			case 'stocktransfer':
				$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
				$columns = $this->getTableColumns($report);				
				$prepare = $vanInventoryPresenter->getPreparedStockTransfer();
				$rows = $vanInventoryPresenter->getStockTransferReportSelectColumns();
				$header = 'Stock Transfer Report';
				$filters = $vanInventoryPresenter->getStockTransferFilterData();
				$filename = 'Stock Transfer Report';
				break;
				
			case 'stockaudit':
				$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
				$columns = $this->getTableColumns($report);
				$prepare = $vanInventoryPresenter->getPreparedStockAudit();
				$rows = $vanInventoryPresenter->getStockAuditReportSelectColumns();
				$header = 'Stock Audit Report';
				$filters = $vanInventoryPresenter->getStockAuditFilterData();
				$filename = 'Stock Audit Report';
				break;
				
			case 'flexideal':
				$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
				$columns = $this->getTableColumns($report);
				$prepare = $vanInventoryPresenter->getPreparedFlexiDeal();
				$summary = $vanInventoryPresenter->getPreparedFlexiDeal(true)->first();
				$rows = $vanInventoryPresenter->getFlexiDealReportSelectColumns();
				$header = 'Flexi Deal Report';
				$filters = $vanInventoryPresenter->getFlexiDealFilterData();
				$filename = 'Flexi Deal Report';
				break;
				
			case 'replenishment':
				return PresenterFactory::getInstance('VanInventory')->exportReplenishment($type);
				break;				
			case 'adjustment':
				return PresenterFactory::getInstance('VanInventory')->exportAdjustment($type);
				break;
			case 'invoiceseries':
				$invoicePresenter = PresenterFactory::getInstance('Invoice');				
				$columns = $this->getTableColumns($report);
				$prepare = $invoicePresenter->getPreparedInvoiceSeries();
				$rows = $invoicePresenter->getInvoiceSeriesSelectColumns();
				$header = 'Invoice Series Mapping';
				$filters = $invoicePresenter->getInvoiceSeriesFilterData();
				$filename = 'Invoice Series Mapping';
				break;
    		default:
    			return;
    	}	
    	
    	if(!$vaninventory)
    	{
    		if($this->request->get('sort') && $this->request->get('order'))
    		{
    			$prepare->orderBy($this->request->get('sort'),$this->request->get('order'));
    		}
    		
	    	$prepare = $prepare->skip($offset)->take($limit);
	    	$records = $prepare->get();
	    	if($salesSummary)
	    	{
	    		$records = $this->populateScrInvoice($records);
	    	}
			if($summaryOfIncident){
				foreach($records as $record){
					$record->location_assignment_code = $record->areas[0]->area_name;
				}
			}
    	}
    	//dd($rows);
    	//dd($filters);
    	/* $this->view->columns = $columns;    	    
    	$this->view->rows = $rows;
    	$this->view->header = $header;
    	$this->view->theadRaw = $theadRaw;
    	$this->view->filters = $filters;
    	$this->view->records = $records; 
    	$this->view->summary = $summary;
    	$this->view->previous = $previous;
    	$this->view->scr = $scr;
    	$this->view->previousSummary = $previousSummary;
    	$this->view->current = $current;
    	//dd($current);
    	$this->view->area = $area;
    	$this->view->currentSummary = $currentSummary;    	
    	$this->view->fontSize = '7px';
    	return $this->view('exportSalesCollectionPdf'); */
		if (empty($current)) {
			$records = $this->validateInvoiceNumber($records);
		} else {
			$current = $this->validateInvoiceNumber($current);
		}
    	  
    	if(in_array($type,['xls','xlsx']))
    	{    
	    	\Excel::create($filename, function($excel) use ($columns,$rows,$records,$summary,$header,$filters,$theadRaw, $report,$current,$currentSummary,$previous,$previousSummary,$scr,$area){
	    		$excel->sheet('Sheet1', function($sheet) use ($columns,$rows,$records,$summary,$header,$filters,$theadRaw, $report,$current,$currentSummary,$previous,$previousSummary, $scr,$area){

					$datas = ($records) ? $records : $current;
					if ($report == 'vaninventorycanned' || $report == 'vaninventoryfrozen') {
						$records = $this->formatExcelColumn($report, $datas, $sheet);
					} else {
						$this->formatExcelColumn($report, $datas, $sheet);
					}
					
					$params['columns'] = $columns;
	    			$params['theadRaw'] = $theadRaw;
	    			$params['rows'] = $rows;
	    			$params['records'] = $records;
	    			$params['summary'] = $summary;
	    			$params['header'] = $header;
	    			$params['scr'] = $scr;
	    			$params['filters'] = $filters;
	    			$params['current'] = $current;
	    			$params['previous'] = $previous;
	    			$params['currentSummary'] = $currentSummary;
	    			$params['previousSummary'] = $previousSummary;
	    			$params['area'] = $area;
	    			$params['report'] = $report;
	    			$view = $report == 'salescollectionreport' ? 'exportSalesCollection' : 'exportXls';  
	    			$sheet->loadView('Reports.'.$view, $params);	    				    		
	    		});
	    	
	    	})->export($type);
    	}
    	elseif($type == 'pdf')
    	{
    		$params['columns'] = $columns;
    		$params['theadRaw'] = $theadRaw;
    		$params['rows'] = $rows;
    		$params['records'] = $records;
    		$params['summary'] = $summary;
    		$params['header'] = $header;
    		$params['scr'] = $scr;
    		$params['filters'] = $filters;
    		$params['fontSize'] = $fontSize;
    		$params['textSize'] = $textSize;
    		$params['current'] = $current;
    		$params['previous'] = $previous;
    		$params['currentSummary'] = $currentSummary;
    		$params['previousSummary'] = $previousSummary;
    		$params['area'] = $area;
    		$params['report'] = $report;
    		$view = $report == 'salescollectionreport' ? 'exportSalesCollectionPdf' : 'exportPdf';
    		if(in_array($report,['salescollectionsummary','stocktransfer','stockaudit','invoiceseries']))
    			$pdf = \PDF::loadView('Reports.'.$view, $params)->setPaper('folio')->setOrientation('portrait');
    		elseif($report == 'salescollectionreport')
    			$pdf = \PDF::loadView('Reports.'.$view, $params)->setPaper('legal');
			else
				$pdf = \PDF::loadView('Reports.'.$view, $params)->setPaper('folio');
    		unset($params,$records,$prepare);	    		
    		return $pdf->download($filename.'.pdf');
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
    		'customer_address',
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
    			'reference_number',    			
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
    			'customer_address',
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
    			'quantity',
    			'condition_code',    			 
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
    			'customer_address',
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
    			'customer_address',
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
    			'customer_address',
			    'remarks',
			    'invoice_number',
			    'invoice_date',
			    'original_amount',
			    'balance_amount'
    	];
    }
    
    /**
     * Return Bir Select Columns
     * @return multitype:string
     */
    public function getBirSelectColumns()
    {
    	return [
    			'document_date',
    			'name',
    			'customer_address',
    			'depot',
    			'reference',
    			'vat_reg_number',
    			'sales_exempt',
    			'sales',
    			'sales_0',    			
    			'total_sales',
    			'tax_amount',
    			'total_invoice_amount',
    			'local_sales',
    			'services',
    			'term_cash',
    			'term_on_acount',
    			'sales_group',
    			'assignment',
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
    			'description',
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
	 * Return summary of incident report select columns
	 * @return multitype:string
	 */
	public function getSummaryOfIncidentReportSelectColumns()
	{
		return [
			'id',
			'subject',	
			'message',
			'action',
			'status',
			'full_name',
			'location_assignment_code',
			'created_at'
		];
	}
    
    /**
     * Return sales collection select columns
     * @return multitype:string
     */
    public function getSalesCollectionSelectColumns($pdf=false)    
    {
    	$columns = [    	
    			'customer_code',
    			'customer_name',
    			'customer_address',
    			'remarks',
    			'invoice_number',
    			'invoice_date',
    			'so_total_served',    			
    			'so_total_item_discount',
    			'so_total_collective_discount',
    			'total_invoice_amount',
    			'ref_no',
    			'other_deduction_amount',
    			'return_slip_num',
    			'RTN_total_gross',
    			'RTN_total_collective_discount',
    			'RTN_net_amount',
    			'total_invoice_net_amount',
    			'or_date',
    			'or_number',
    			'cash_amount',
    			'check_amount',
    			'bank',
    			'check_number',
    			'check_date',
    			'cm_number',
    			'cm_date',
    			'credit_amount',
    			'total_collected_amount',
    	];
    	
    	if($pdf)
    		unset($columns[5],$columns[6],$columns[7],$columns[12],$columns[13]);
    		 
		return $columns;
    		 
    }
    
    
    /**
     * Return sales collection select columns
     * @return multitype:string
     */
    public function getSalesCollectionSummarySelectColumns()
    {
    	return [
    			'scr_number',
    			'invoice_number_from',
    			'invoice_number_to',
    			'invoice_date',
    			'total_collected_amount',
    			'sales_tax',
    			'amt_to_commission',    			
    	];
    }
    
    /**
     * Return sales collection posting select columns
     * @return multitype:string
     */
    public function getSalesCollectionPostingSelectColumns()
    {
    	return [
    			'activity_code',
    			'salesman_name',
    			'customer_code',
    			'customer_name',
    			'remarks',
    			'invoice_number',
    			'total_invoice_net_amount',
    			'invoice_date',
    			'invoice_posting_date',
    			'or_number',
    			'or_amount',
    			'or_date',
    			'collection_posting_date',
    	];
    }
    
    
    /**
     * Get report data count
     * @param string $report
     * @return JSON the data count
     */
    public function getDataCount($report, $type='xls', $dashboard=false)
    {
    	$data = [];
    	$prepare = '';
    	$special = false;
    	switch($report)
    	{
    		case 'salescollectionreport';
	    		$prepare = $this->getPreparedSalesCollection();    			
    			$collection1 = $prepare->get();
    			 
    			$referenceNum = [];
		    	$invoiceNum = [];
		    	foreach($collection1 as $col)
		    	{
		    		$referenceNum[] = $col->reference_num;
		    		$invoiceNum[] = $col->invoice_number;
		    	}
		    	
		    	array_unique($referenceNum);
		    	array_unique($invoiceNum);
		    	$except = $referenceNum ? ' AND tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\') ' : '';
		    	$except .= $invoiceNum ? ' AND coltbl.invoice_number NOT IN(\''.implode("','",$invoiceNum).'\') ' : '';
    			
    			$prepare = $this->getPreparedSalesCollection2(false,$except);
    			$collection2 = $prepare->get();
    			 
    			$collection = array_merge((array)$collection1,(array)$collection2);
    			$records = $this->formatSalesCollection($collection);
    			
    			$total = count($records);
    			$special = true;
    			
	    		break;
    		case 'salescollectionposting';
	    		$prepare = $this->getPreparedSalesCollectionPosting();
    			$collection1 = $prepare->get();
    	
    			$referenceNum = [];
    			foreach($collection1 as $col)
    			{
    				$referenceNum[] = $col->reference_num;
    			}
    	
		    	array_unique($referenceNum);
		    	$except = $referenceNum ? ' AND (tas.reference_num NOT IN(\''.implode("','",$referenceNum).'\')) ' : '';

		    	$prepare = $this->getPreparedSalesCollectionPosting2($except);
		    	$collection2 = $prepare->get();
    	
    			$records = array_merge($collection1,$collection2);    			
    			$total = count($records);
    			$special = true;
	    		break;
	    	case 'salescollectionsummary';
	    		$prepare = $this->getPreparedSalesCollectionSummary();
	    		break;
    		case 'bir';
    			$prepare = $this->getPreparedBir();
    			break;
    		case 'unpaidinvoice';
    			$prepare = $this->getPreparedUnpaidInvoice();
    			break;
    		case 'vaninventorycanned':
    		case 'vaninventoryfrozen':    			
    			if($dashboard)
    			{
    				$this->getPreparedVanInventory();
    			}
    			else
    			{
	    			$data['total'] = 1;
	    			$data['limit'] = 0;
	    			$data['max_limit'] = false;
	    			$data['staggered'] = [];   
	    			return response()->json($data);
    			}
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
			case 'summaryofincidentsreport':
				$prepare = PresenterFactory::getInstance('User')->getPreparedSummaryOfIncidentReportList(false);
				$total = count($prepare->get());
				$special = true;
				break;
			case 'stocktransfer':
				$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedStockTransfer();
				$total = $prepare->count();
				break;
			case 'stockaudit':
				$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedStockAudit();
				$total = $prepare->count();
				break;
			case 'flexideal':
				$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedFlexiDeal();
				$total = $prepare->count();
				break;
			case 'replenishment':
				$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedRelenishment();
				$total = $prepare->count();
				break;
			case 'adjustment':
				$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedAdjustment();
				$total = $prepare->count();
				break;
			case 'invoiceseries':
				$prepare = PresenterFactory::getInstance('Invoice')->getPreparedInvoiceSeries();
				$total = $prepare->count();
				break;
    		default:
    			return;
    	}
    	
    	if(!$special)
    		$total = $prepare->getCountForPagination();
    	
    	if(in_array($type,['xls','xlsx']))
    		$limit = config('system.report_limit_xls');
    	else
    		$limit = config('system.report_limit_pdf');
    	
    	if(in_array($report,['salesreportpermaterial','salesreportperpeso']) && !in_array($type,['xls','xlsx']))
    		$limit = 50;
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
    			$customer = $this->request->get('customer') ? $this->getCustomer(false)[$this->request->get('customer')] : 'All';
    			$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    			$material = $this->request->get('material') ? $this->getItems()[$this->request->get('material')] : 'All';
    			$segment = $this->request->get('segment') ? $this->getItemSegmentCode()[$this->request->get('segment')] : 'All';
    			$returnDate = ($this->request->get('return_date_from') && $this->request->get('return_date_to')) ? $this->request->get('return_date_from').' - '.$this->request->get('return_date_to') : 'All';
    			$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    			$invoiceNum = $this->request->get('invoice_number');
    			 
    			$filters = [
    					'Salesman' => $salesman,
    					'Area' => $area,
    					'Customer Name' => $customer,
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
    			$customer = $this->request->get('customer') ? $this->getCustomer(false)[$this->request->get('customer')] : 'All';
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
    			$customer = $this->request->get('customer') ? $this->getCustomer(false)[$this->request->get('customer')] : 'All';
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
    					'Return Slip #' => $invoiceNum
    			];		
    			break;
    		case 'returnperpeso':
    				$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    				$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    				$customer = $this->request->get('customer') ? $this->getCustomer(false)[$this->request->get('customer')] : 'All';
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
    						'Return Slip #' => $invoiceNum
    				];
    				break;
    		 case 'customerlist':
    				$salesman = $this->request->get('salesman_code') ? $salesman = $this->getSalesman()[$this->request->get('salesman_code')] : 'All';
    				$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    				$company_code = $this->request->get('company_code') ? $this->getCompanyCode()[$this->request->get('company_code')] : 'All';
    				$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    				$sfa_modified_date = ($this->request->get('sfa_modified_date_from') && $this->request->get('sfa_modified_date_to')) ? $this->request->get('sfa_modified_date_from').' - '.$this->request->get('sfa_modified_date_to') : 'All';
    				
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
    				$sfa_modified_date = ($this->request->get('sfa_modified_date_from') && $this->request->get('sfa_modified_date_to')) ? $this->request->get('sfa_modified_date_from').' - '.$this->request->get('sfa_modified_date_to') : 'All';
    				
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
    				$sfa_modified_date = ($this->request->get('sfa_modified_date_from') && $this->request->get('sfa_modified_date_to')) ? $this->request->get('sfa_modified_date_from').' - '.$this->request->get('sfa_modified_date_to') : 'All';
	    			 
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
//    	$status = $this->request->get('status') ? $this->getCustomerStatus()[$this->request->get('status')] : 'All';
    	
    	$invoiceNum = $this->request->get('invoice_number');
    	$stockTransNum = $this->request->get('stock_transfer_number');
    	$returnSlipNum = $this->request->get('return_slip_num');
    	$referenceNum = $this->request->get('reference_number');
    	
    	$transDate = ($this->request->get('transaction_date_from') && $this->request->get('transaction_date_to')) ? $this->request->get('transaction_date_from').' - '.$this->request->get('transaction_date_to') : 'None';
    	
    	$filters = [
    			'Salesman' => $salesman,
  //  			'Status' => $status,
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
    	$invoiceNum = $this->request->get('invoice_number');
    	
    	$filters = [
    			'Salesman' => $salesman,
    			'Company' => $company,
    			'Customer' => $customer,
    			'Invoice Date' => $invoiceDate,
    			'Invoice #' => $invoiceNum,
    	];
    	 
    	return $filters;
    }
    
    
    /**
     * Get Van inventory filters
     */
    public function getBirFilterData()
    {
    	$filters = [];
    
    	$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    	$salesman = $this->request->get('salesman') ? $this->getSalesman()[$this->request->get('salesman')] : 'All';
    	$documentDate = ($this->request->get('document_date_from') && $this->request->get('document_date_to')) ? $this->request->get('document_date_from').' - '.$this->request->get('document_date_to') : 'All';
    	$reference = $this->request->get('reference');
    
    	$filters = [
    			'Salesman' => $salesman,
    			'Area' => $area,
    			'Document Date' => $documentDate,
    			'Reference #' => $reference,
    	];
    
    	return $filters;
    }

	/**
	 * Get Summary of incidents report filters.
	 */
	public function getSummaryOfIncidentReportFilterData()
	{
		$name = ModelFactory::getInstance('ContactUs')->where('full_name',
			$this->request->get('name'))->distinct()->first();
		$name = ($name) ? $name->full_name : 'All';
		$branch = ModelFactory::getInstance('AppArea')->where('area_code', $this->request->get('branch'))->first();
		$branch = ($branch) ? $branch->area_name : 'All';
		$incident_no = ($this->request->get('incident_no')) ?: 'All';
		$subject = ($this->request->get('subject')) ?: 'All';
		$action = ($this->request->get('action')) ?: 'All';
		$status = ($this->request->get('status')) ?: 'All';
		$date = ($this->request->get('date_range_from') && $this->request->get('date_range_to')) ? $this->request->get('date_range_from') . ' - ' . $this->request->get('date_range_to') : 'All';
		$filters = [
			'Reporter'   => $name,
			'Branch'     => $branch,
			'Incident #' => $incident_no,
			'Subject'    => $subject,
			'Action'     => $action,
			'Status'     => $status,
			'Date'       => $date
		];

		return $filters;
	}
    
    
    /**
     * Get Sales Collection Filter Data
     */
    public function getSalesCollectionFilterData($collection=false)    
    {
    	$filters = [];
    
    	$customer = $this->request->get('company_code') ?  $this->request->get('company_code') : 'All';
    	$salesman = $this->request->get('salesman') ? $this->getSalesman(false)[$this->request->get('salesman')] : 'All';
    	$invoiceDate = ($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to')) ? $this->request->get('invoice_date_from').' - '.$this->request->get('invoice_date_to') : 'All';
    	$collectiontDate = ($this->request->get('collection_date_from') && $this->request->get('collection_date_to')) ? $this->request->get('collection_date_from').' - '.$this->request->get('collection_date_to') : 'All';
    	$postingDate = ($this->request->get('posting_date_from') && $this->request->get('posting_date_to')) ? $this->request->get('posting_date_from').' - '.$this->request->get('posting_date_to') : 'All';
    	$invoice = $this->request->get('invoice_number') ? $this->request->get('invoice_number') : 'All';
    	$or = $this->request->get('or_number') ? $this->request->get('or_number') : 'All';
    	$name = $this->request->get('customer_name') ? $this->request->get('customer_name') : 'All';
		$jrSalesman = ModelFactory::getInstance('User');
		$jrSalesman = $jrSalesman->where('salesman_code', 'Like', '%' . $this->request->get('salesman') . '-%')->where('status', 'A')->first();


		$filters = [
    			'Invoice Date' => $invoiceDate,
    			'Collection Date' => $collectiontDate,
    			'Invoice #' => $invoice,
    			'OR #' => $or,
    			'Company Code' => $customer,
    			'Customer Name' => $name,
    			'Salesman' => $salesman,
				'Jr. Salesman' => ($jrSalesman) ? $jrSalesman->full_name . ' - ' . $jrSalesman->salesman_code: null,
				'Posting Date' => $postingDate,
    	];
    	
    	if($collection)
    	{
    		unset($filters['Posting Date']);
    		$filters['Previous Invoice Date'] = $postingDate;
    	}
    	 
    
    	return $filters;
    }
    
    
    /**
     * Get Sales Collection Filter Data
     */
    public function getSalesCollectionSummaryFilterData()
    {
    	$filters = [];
    
    	$customer = $this->request->get('customer_code') ?  $this->request->get('customer_code') : 'All';
    	$salesman = $this->request->get('salesman') ? $this->getSalesman()[$this->request->get('salesman')] : 'All';
    	$area = $this->request->get('area') ? $this->getArea()[$this->request->get('area')] : 'All';
    	$invoice = $this->request->get('invoice_date_from') ? (new Carbon($this->request->get('invoice_date_from')))->format('F Y') : '';
    	 
    	$filters = [
    			'Company Code' => $customer,
    			'Salesman' => $salesman,
    			'Area' => $area,
    			'Month Description' => $invoice,
    	];
    
    	return $filters;
    }
    
    /**
     * Update report summary columns
     */
    public function updateReportSummary()
    {
    	$salesCollection = $this->getDataCount('salescollectionreport');
    	$unpaid = $this->getPreparedUnpaidInvoice(false,true)->getCountForPagination();
    	$van = $this->getDataCount('vaninventorycanned','xls',true);
    	$bir = $this->getDataCount('bir');
    	$sales = $this->getDataCount('salesreportpermaterial');
    	
    	$today = new \DateTime();
    	$data = [
    		['report'=>'salescollection','count'=>$salesCollection->getData()->total,'created_at'=>$today,'updated_at'=>$today],
    		['report'=>'unpaidinvoice','count'=>$unpaid,'created_at'=>$today,'updated_at'=>$today],
    		['report'=>'van','count'=>$van->getData()->total,'created_at'=>$today,'updated_at'=>$today],
    		['report'=>'bir','count'=>$bir->getData()->total,'created_at'=>$today,'updated_at'=>$today],
    		['report'=>'salesreport','count'=>$sales->getData()->total,'created_at'=>$today,'updated_at'=>$today],
    	];
    	
    	\DB::table('report_summary')->delete();
    	
    	\DB::table('report_summary')->insert($data);
    }
    
    
    /**
     * Update stock on hand 
     */
    public function updateStockOnHand()
    {
    	$replenishmentNum = ModelFactory::getInstance('StockOnHand')->lists('replenishment_number');
    	
    	$prepare = ModelFactory::getInstance('TxnReplenishmentHeader')->with('salesman','details');
    	if(!$replenishmentNum->isEmpty())
    		$prepare->whereNotIn('reference_number',$replenishmentNum->toArray());
    	
    	$prepare->orderBy('replenishment_date');
    	$replenishments = $prepare->get();
    	    	
    	foreach($replenishments as $replenish)
    	{
    		if($replenish->salesman)
    		{
    			$prevReplenish = ModelFactory::getInstance('StockOnHand')
					    			->where('salesman_code',$replenish->salesman->salesman_code)
					    			->where('stock_date','<',$replenish->replenishment_date)
					    			->orderBy('stock_date','desc')
					    			->first();
    			$prevRefNum = $prevReplenish ? $prevReplenish->replenishment_number : null;
    			$this->computeStockOnHand($replenish->reference_number, $prevRefNum);    			
    		}
    		 
    	}
    	
    }
    
    /**
     * Compute stock on hand
     * @param unknown $currentRnum
     * @param unknown $previousRnum
     * @return multitype:|multitype:number Ambigous <string, number>
     */
    public function computeStockOnHand($currentRnum, $previousRnum=null)
    {
    	
    	$currentReplenish = ModelFactory::getInstance('TxnReplenishmentHeader')
    								->with('salesman','details')
    								->where('reference_number',$currentRnum)
    								->first();
    	$previousReplenish = '';
    	if($previousRnum)
    		$previousReplenish = ModelFactory::getInstance('StockOnHand')
    								->with('items')
    								->where('replenishment_number',$previousRnum)
    								->first();
    	
    	if(!$currentReplenish)
    		return false;    	
    	
    	$stockOnHand = [];
    	
    	$to = (new Carbon($currentReplenish->replenishment_date));
    	$goLive = new Carbon(config('system.go_live_date'));
    	
    	//Replenishment
    	if($previousReplenish)
    	{
	    	foreach($previousReplenish->items as $item)
	    	{
	    		if(!isset($stockOnHand[$item->item_code]))
	    			$stockOnHand[$item->item_code] = 0;
	    		$stockOnHand[$item->item_code] += $item->quantity;	    	
	    	}
	    	$from = (new Carbon($previousReplenish->stock_date))->addDay();
    	}
    	else
    	{
    		foreach($currentReplenish->details as $item)
    		{
    			if(!isset($stockOnHand[$item->item_code]))
    				$stockOnHand[$item->item_code] = 0;
    			$stockOnHand[$item->item_code] += $item->quantity;    			
    		}
    		$from = new Carbon($to);
    	}

    	$salesmanCode = $currentReplenish->salesman->salesman_code;
    	$dates = [];    	
    	while($from->lte($to))
    	{
    		$date = $from->format('Y-m-d');
    		
	    	$stockTransfers = ModelFactory::getInstance('TxnStockTransferInHeader')
							    	->with('details')
							    	->where(\DB::raw('DATE(transfer_date)'),$date)
							    	->where('salesman_code',$salesmanCode)
							    	->orderBy('transfer_date')
							    	->get();
	    	
	    	// Stock Transfer
	    	$stockTransferItemCount = [];
	    	if($stockTransfers)
	    	{
	    		foreach($stockTransfers as $stock)
	    		{
	    			foreach($stock->details as $item)
	    			{
	    				if(!isset($stockOnHand[$item->item_code]))
	    					$stockOnHand[$item->item_code] = 0;
	    				$stockOnHand[$item->item_code] += $item->quantity;
	    			}	
	    		}    		
	    	}
	    	
	    	$sales = ModelFactory::getInstance('TxnSalesOrderHeader')
	    							->with('details','customer')
	    							->where(\DB::raw('DATE(so_date)'),$date)
	    							->where('salesman_code',$salesmanCode)
	    							->orderBy('so_date')
	    							->get();
	    	
	    	// Sales Invoice
	    	$salesItemCount = [];
	    	if($sales)
	    	{
	    		foreach($sales as $sale)
	    		{
	    			foreach($sale->details as $item)
	    			{
	    				if(!isset($stockOnHand[$item->item_code]))
	    					$stockOnHand[$item->item_code] = 0;
	    				if(false !== strpos($sale->customer->customer_name, '_Van to Warehouse'))
	    					$stockOnHand[$item->item_code] -= $item->order_qty;
	    				elseif(false !== strpos($sale->customer->customer_name, '_Adjustment'))
	    					$stockOnHand[$item->item_code] -= $item->order_qty;
	    				else 
	    					$stockOnHand[$item->item_code] -= $item->quantity;
	    			}
	    		}
	    	}	    	
	    	
	    	$returns = ModelFactory::getInstance('TxnReturnHeader')
						    	->with('details','customer')
						    	->where(\DB::raw('DATE(return_date)'),$date)
						    	->where('salesman_code',$salesmanCode)
						    	->orderBy('return_date')
						    	->get();
	    	
	    	
	    	// Returns Invoice
	    	$returnsItemCount = [];
	    	if($returns)
	    	{
	    		foreach($returns as $return)
	    		{
	    			foreach($return->details as $item)
	    			{
	    				if(!isset($stockOnHand[$item->item_code]))
	    					$stockOnHand[$item->item_code] = 0;
	    				$stockOnHand[$item->item_code] += $item->quantity;
	    			}
	    		}
	    	}	    	
	    	
	    	if($from->eq($to))
	    	{	    		
	    		foreach($currentReplenish->details as $item)
	    		{
	    			if(!isset($stockOnHand[$item->item_code]))
	    				$stockOnHand[$item->item_code] = 0;
	    			$stockOnHand[$item->item_code] -= $item->quantity;
	    		}
	    	}	    	

	    	$stock = ModelFactory::getInstance('StockOnHand');
	    	if($from->eq($to))
	    		$stock->replenishment_number = $currentReplenish->reference_number;
	    	else
	    		$stock->replenishment_number = $previousReplenish ? $previousReplenish->replenishment_number : $currentReplenish->reference_number;
	    	$stock->salesman_code = $salesmanCode;
	    	$stock->stock_date = new \DateTime($date);
	    	
	    	$dates[] = $date;
	    	 
	    	if($from->eq($goLive))
	    		$stock->beginning = 1;
	    	 
	    	if($stock->save())
	    	{
		    	foreach($stockOnHand as $code=>$qty)
		    	{
		    		$stockItem = ModelFactory::getInstance('StockOnHandItems');
		    		$stockItem->stock_on_hand_id = $stock->id;
		    		$stockItem->item_code = $code;
		    		$stockItem->quantity = $qty;
		    		$stockItem->save();	    		
		    	}
	    	}
	    	
	    	$from->addDay();	    	
    	}      	
    }

	/**
	 * This function will check if the invoice number has an
	 * invoice code it append an invoice code for the invoice number
	 * don't have invoice code.
	 * @param $currents
	 * @return mixed
	 */
	public function validateInvoiceNumber($currents)
	{
		foreach ($currents as &$current) {
			//check if the current variable has a property of invoice_number,has a numeric value and not equal to white space.
			if (isset($current->invoice_number_from) && isset($current->invoice_number_to)) {
				if ($current->invoice_number_from != " " && is_numeric($current->invoice_number_from)) {
					$current->invoice_number_from = $this->generateInvoiceNumber($current->customer_code) . $current->invoice_number_from;
				}
				if ($current->invoice_number_to != " " && is_numeric($current->invoice_number_to)) {
					$current->invoice_number_to = $this->generateInvoiceNumber($current->customer_code) . $current->invoice_number_to;
				}
			} elseif (isset($current->invoice_number)) {
				if ($current->invoice_number != " " && is_numeric($current->invoice_number)) {
					if (isset($current->customer_code)) {
						$current->invoice_number = $this->generateInvoiceNumber($current->customer_code) . $current->invoice_number;
					} else {
						$current->invoice_number = $this->generateInvoiceNumber($current->customer_name,
								true) . $current->invoice_number;
					}
				}
			} elseif (is_array($current) && array_key_exists('invoice_number', $current)) {
				if ($current['invoice_number'] != " " && is_numeric($current['invoice_number'])) {
					$current['invoice_number'] = $this->generateInvoiceNumber($current['customer_name'],
							true) . $current['invoice_number'];
				}
			}
		}
		return $currents;
	}
	/**
	 * This will return an Area code of a specific customer.
	 * @param $customer
	 * @param bool $isName
	 * @return mixed
	 * @internal param $customerCode
	 */
	public function getCustomerAreaCode($customer, $isName = false)
	{
		$code = ModelFactory::getInstance('AppCustomer');
		if ($isName) {
			$code = $code->where('customer_name', $customer)->select('area_code')->first();
		} else {
			$code = $code->where('customer_code', $customer)->select('area_code')->first();
		}
		return $code;
	}
	/**
	 * Array list of Area codes.
	 * @return array
	 */
	public function arrayOfAreaCodes()
	{
		$areaCodes = [
			'100'  => 'CB',
			'200'  => 'CB',
			'300'  => 'BA',
			'400'  => 'BU',
			'500'  => 'CD',
			'600'  => 'DV',
			'700'  => 'DU',
			'800'  => 'GE',
			'900'  => 'IL',
			'1000' => 'ML',
			'1100' => 'OZ',
			'1200' => 'TA',
			'1300' => 'ZA',
			'1400' => 'OR',
			'2100' => 'CB',
			'2200' => 'CB',
			'2300' => 'BA',
			'2400' => 'BU',
			'2500' => 'CD',
			'2600' => 'DV',
			'2700' => 'DU',
			'2800' => 'GE',
			'2900' => 'IL',
			'3000' => 'ML',
			'3100' => 'OZ',
			'3200' => 'TA',
			'3300' => 'ZA',
			'3400' => 'OR'
		];
		return $areaCodes;
	}
	/**
	 * This will generate an invoice code for an invoice number.
	 * @param $customer
	 * @param bool $isVan
	 * @return string
	 */
	public function generateInvoiceNumber($customer, $isVan = false)
	{
		$areaCodes = $this->arrayOfAreaCodes();
		$customerCode = $this->getCustomerAreaCode($customer, $isVan)->area_code;
		$code = (int)explode('_', $customer)[0];
		$invoice_key = config('system.invoice_key');
		$invoiceCode = $invoice_key[$code] . $areaCodes[$customerCode];
		return $invoiceCode;
	}
    
    
    /**
	 * Check if synching
	 * @return number
	 */
	public function isSynching($id, $column)
	{
		$data = \DB::table('settings')->where('name', 'synching_sfi')->first();
		$resultdata = ModelFactory::getInstance('TableLog');
		$resultdata = $resultdata->where('pk_id', $id)->where('column', $column)->with('users')->orderBy('created_at',
			'asc')->get();
		$value['sync'] = ($data && $data->value) ? 1 : 0;
		$value['com'] = $resultdata;

		return response()->json(['sync_data' => $value]);
	}

	/**
	 * This function will format the value to excel form.
	 * @param $report
	 * @param $records
	 * @param $sheet
	 * @return mixed
     */
	private function formatExcelColumn($report, $records, $sheet)
	{
		switch ($report) {
			case 'salesreportpermaterial':
				$sheet->setColumnFormat([
					'N:O' => 'MM/DD/YYYY',
					'V:W' => '0,0.00',
					'X'   => '0%',
					'Y'   => '0,0.00',
					'Z'   => '0%',
					'AA'  => '0,0.00',
					'AD'  => '0,0.00'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'materialpricelist':
				$sheet->setColumnFormat([
					'G:H' => 'MM/DD/YYYY',
					'J'   => 'MM/DD/YYYY'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'salesmanlist':
				$sheet->setColumnFormat([
					'F' => 'MM/DD/YYYY'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'customerlist':
				$sheet->setColumnFormat([
					'N' => 'MM/DD/YYYY'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'returnperpeso':
				$sheet->setColumnFormat([
					'N:O' => 'MM/DD/YYYY',
					'P:Q' => '0,0.00',
					'R'   => '0%',
					'S'   => '0,0.00',
					'T'   => '0%',
					'U'   => '0,0.00',
					'X'   => '0,0.00',
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'returnpermaterial':
				$sheet->setColumnFormat([
					'N:O' => 'MM/DD/YYYY',
					'V:W' => '0,0.00',
					'X'   => '0%',
					'Y'   => '0,0.00',
					'Z'   => '0%',
					'AA'  => '0,0.00',
					'AD'  => '0,0.00',
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'unpaidinvoice':
				$sheet->setColumnFormat([
					'H'   => 'MM/DD/YYYY',
					'I:J' => '0,0.00',
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'salescollectionsummary':
				$sheet->setColumnFormat([
					'D'   => 'MM/DD/YYYY',
					'E:G' => '0,0.00'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'salescollectionposting':
				$sheet->setColumnFormat([
					'G'   => '0,0.00',
					'H:I' => 'MM/DD/YYYY',
					'K'   => '0,0.00',
					'L:M' => 'MM/DD/YYYY',
					'J' => \PHPExcel_Style_NumberFormat::FORMAT_TEXT,
					'F' => \PHPExcel_Style_NumberFormat::FORMAT_TEXT

				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'salescollectionreport':
				$sheet->setColumnFormat([
					'F'     => 'MM/DD/YYYY',
					'G:J'   => '0,0.00',
					'L'     => '0,0.00',
					'N:Q'   => '0,0.00',
					'R'     => 'MM/DD/YYYY',
					'T:U'   => '0,0.00',
					'X'     => 'MM/DD/YYYY',
					'AA:AB' => '0,0.00',
					'V' => \PHPExcel_Style_NumberFormat::FORMAT_TEXT,
					'D' => \PHPExcel_Style_NumberFormat::FORMAT_TEXT

				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'bir':
				$sheet->setColumnFormat([
					'A'   => 'MM/DD/YYYY',
					'H'   => '0,0.00',
					'J:O' => '0,0.00',
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'salesreportperpeso':
				$sheet->setColumnFormat([
					'R'   => '0%',
					'T'   => '0%',
					'P:Q' => '0,0.00',
					'S'   => '0,0.00',
					'U'   => '0,0.00',
					'X'   => '0,0.00'
				]);
				$this->formatValueForExcel($report, $records);
				break;
			case 'vaninventoryfrozen':
			case 'vaninventorycanned':
				$sheet->setColumnFormat([
					'B' => 'MM/DD/YYYY',
					'E' => 'MM/DD/YYYY',
					'G' => 'MM/DD/YYYY',
				]);
				$records = $this->formatValueExcelVanInventory($records);
				break;
		}

		return $records;
	}

	/**
	 * This function will format the value for excel data.
	 * @param $report
	 * @param $records
	 */
	private function formatValueForExcel($report, $records)
	{
		foreach ($records as &$record) {
			switch ($report) {
				case 'bir':
					$record->document_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->document_date));
					break;
				case 'salescollectionreport':
					$record->check_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->check_date));
					break;
				case 'salescollectionposting':
					$record->collection_posting_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->collection_posting_date));
					break;
				case 'returnpermaterial':
				case 'returnperpeso':
					$record->return_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->return_date));
					$record->return_posting_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->return_posting_date));
					break;
				case 'materialpricelist':
					$record->effective_date_to = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->effective_date_to));
					$record->effective_date_from = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->effective_date_from));
					break;
			}
			switch ($report) {
				case 'salesreportpermaterial':
				case 'salesreportperpeso':
				case 'returnperpeso':
				case 'returnpermaterial':
					$record->discount_rate = ($record->discount_rate) ? $record->discount_rate / 100 : 0;
					$record->collective_discount_rate = ($record->collective_discount_rate) ? $record->collective_discount_rate / 100 : 0;
					break;
				case 'materialpricelist':
				case 'customerlist':
				case 'salesmanlist':
					$record->sfa_modified_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->sfa_modified_date));
					break;
			}
			switch ($report) {
				case 'salescollectionreport':
				case 'salescollectionposting':
					$record->or_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->or_date));
					break;
			}
			switch ($report) {
				case 'salescollectionposting':
				case 'salesreportpermaterial':
					$record->invoice_posting_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->invoice_posting_date));
					break;
			}
			switch ($report) {
				case 'salesreportpermaterial':
				case 'salescollectionreport':
				case 'salescollectionposting':
				case 'salescollectionsummary':
				case 'unpaidinvoice':
					$record->invoice_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->invoice_date));
					break;
			}
		}
	}

	/**
	 * This function will format the value for excel data in van inventory report.
	 * @param $records
	 * @return mixed
	 */
	private function formatValueExcelVanInventory($records)
	{
		foreach ($records as &$record) {
			if (is_array($record) && array_key_exists('invoice_date', $record)) {
				$record['invoice_date'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($record['invoice_date']));
			} elseif (isset($record->invoice_date)) {
				$record->invoice_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->invoice_date));
			}
			if (is_array($record) && array_key_exists('transaction_date', $record)) {
				$record['transaction_date'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($record['transaction_date']));
			} elseif (isset($record->transaction_date)) {
				$record->transaction_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->transaction_date));
			}
			if (is_array($record) && array_key_exists('replenishment_date', $record)) {
				$record['replenishment_date'] = PHPExcel_Shared_Date::PHPToExcel(strtotime($record['replenishment_date']));
			} elseif (isset($record->replenishment_date)) {
				$record->replenishment_date = PHPExcel_Shared_Date::PHPToExcel(strtotime($record->replenishment_date));
			}
		}

		return $records;
	}
}
