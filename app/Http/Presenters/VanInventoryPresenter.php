<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;
use DB;
use Carbon\Carbon;
use App\Factories\ModelFactory;
use App\Http\Models\Replenishment;

class VanInventoryPresenter extends PresenterCore
{
	
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function createStockTransfer()
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems();
		$this->view->segments = $reportsPresenter->getItemSegmentCode();
		$this->view->brands = $this->getBrands();
		$this->view->uom = $this->getUom();
		$this->view->stockTransfers = stock_transfer();
		$this->view->salesman = $reportsPresenter->getSalesman(true);
		return $this->view('add');
	}
	
	
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function createActualCount()
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems(true);
		$this->view->jrSalesmans = $this->getJrSalesman();
		$this->view->vanCodes = $this->getVanCodes();
		$this->view->salesman = $reportsPresenter->getSalesman(true);		
		$this->view->replenishment = ModelFactory::getInstance('Replenishment');
		return $this->view('addActualCount');
	}
	
	
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function createAdjustment()
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems(true);
		$this->view->jrSalesmans = $this->getJrSalesman();
		$this->view->vanCodes = $this->getVanCodes();
		$this->view->salesman = $reportsPresenter->getSalesman(true);
		$this->view->segmentCodes = item_segment();
		$this->view->brandCodes = brands();
		$this->view->replenishment = ModelFactory::getInstance('Replenishment');
		return $this->view('addAdjustment');
	}
	
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function editActualCount($referenceNum)
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems(true);
		$this->view->jrSalesmans = $this->getJrSalesman();
		$this->view->vanCodes = $this->getVanCodes();
		$this->view->salesman = $reportsPresenter->getSalesman(true);
		$replenishment = ModelFactory::getInstance('Replenishment')->with('items')->where('reference_number',$referenceNum)->first();
		if(!$replenishment)
			$replenishment = ModelFactory::getInstance('Replenishment');
		$this->view->replenishment = $replenishment;
		return $this->view('addActualCount');
	}
	
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function editAdjustment($referenceNum)
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems(true);
		$this->view->jrSalesmans = $this->getJrSalesman();
		$this->view->vanCodes = $this->getVanCodes();
		$this->view->salesman = $reportsPresenter->getSalesman(true);
		$this->view->segmentCodes = item_segment();
		$this->view->brandCodes = brands();
		$replenishment = ModelFactory::getInstance('Replenishment')->with('items')->where('reference_number',$referenceNum)->first();
		if(!$replenishment)
			$replenishment = ModelFactory::getInstance('Replenishment');
		$this->view->replenishment = $replenishment;
		return $this->view('addAdjustment');
	}
	
    /**
     * Return van & inventory view
     * @param string $type
     * @return string The rendered html view
     */
    public function stockTransfer()
    {    	
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->companyCode = $reportsPresenter->getCompanyCode();
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->items = $reportsPresenter->getItems();
    	$this->view->segments = $reportsPresenter->getItemSegmentCode();
    	$this->view->tableHeaders = $this->getStockTransferColumns();
    	return $this->view('stocktransfer');    	    	
    }
    
    /**
     * Return van & inventory stock audit view
     * @param string $type
     * @return string The rendered html view
     */
    public function stockAudit()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);    	
    	$this->view->areas = $reportsPresenter->getRdsSalesmanArea();
    	$this->view->tableHeaders = $this->getStockAuditColumns();
    	return $this->view('stockAudit');
    }
    
    
    /**
     * Return van inventory replenishment view
     * @param string $type
     * @return string The rendered html view
     */
    public function actualCount()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->tableHeaders = $this->getActualCountColumns();
    	return $this->view('actualCount');
    }
    
    /**
     * Return van inventory replenishment adjustment view
     * @param string $type
     * @return string The rendered html view
     */
    public function adjustment()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);    	
    	$this->view->tableHeaders = $this->getAdjustmentColumns();
    	return $this->view('adjustment');
    }
    
    /**
     * Return van & inventory stock audit view
     * @param string $type
     * @return string The rendered html view
     */
    public function flexiDeal()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->areas = $reportsPresenter->getArea();
    	$this->view->companyCode = $reportsPresenter->getCompanyCode();
    	$this->view->customers = $reportsPresenter->getCustomer();
    	$this->view->items = $reportsPresenter->getItemCodes();
    	$this->view->tableHeaders = $this->getFlexiDealColumns();    	
    	return $this->view('flexiDeal');
    }
    
    
    /**
     * Get Stock transfer column headers
     * @return string[][]
     */
    public function getStockTransferColumns()
    {
    	$headers = [    			
    			['name'=>'Stock Transfer No.','sort'=>'stock_transfer_number'],
    			['name'=>'Transaction Date','sort'=>'transfer_date'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Area','sort'=>'area'],
    			['name'=>'From Loc/Van Salesman','sort'=>'dest_van_code'],    			
    			['name'=>'Segment','sort'=>'segment_code'],
    			['name'=>'Brand','sort'=>'brand'],
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Item Description','sort'=>'description'],
    			['name'=>'UOM'],
    			['name'=>'Qty'],
    		
    	];
    	
    	return $headers;
    }
    
    /**
     * Get Stock transfer column headers
     * @return string[][]
     */
    public function getFlexiDealColumns()
    {
    	$headers = [
    			['name'=>'Area','sort'=>'area_name'],
    			['name'=>'Salesman Code','sort'=>'salesman_code'],
    			['name'=>'Salesman Name','sort'=>'salesman_name'],
    			['name'=>'Customer','sort'=>'customer_name'],
    			['name'=>'Invoice No.','sort'=>'invoice_number'],
    			['name'=>'Invoice Date','sort'=>'invoice_date'],
    			['name'=>'Customer Address' ,'sort'=>'customer_address'],
    			['name'=>'Regular Item Code','sort'=>'item_code'],
    			['name'=>'Regular Item Description' ,'sort'=>'item_desc'],
    			['name'=>'Quantity'],
    			['name'=>'Deal Item Code','sort'=>'trade_item_code'],
    			['name'=>'Deal Item Description','sort'=>'deal_item_desc'],
    			['name'=>'Quantity'],
    			['name'=>'Amount'],
    	];
    
    	return $headers;
    }
    
    /**
     * Return STock transfer report columns
     * @return multitype:string
     */
    public function getFlexiDealReportSelectColumns()
    {
    	return [
    			'area_name',
    			'salesman_code',
    			'salesman_name',
    			'customer_name',
    			'invoice_number',
    			'invoice_date',
    			'customer_address',
    			'item_code',
    			'item_desc',
    			'regular_order_qty',
    			'trade_item_code',
    			'deal_item_desc',
    			'trade_order_qty',
    			'gross_order_amount',
    	];
    }
    
    
    /**
     * Get replenishment table headers
     * @return string[][]
     */
    public function getActualCountColumns()
    {
    	$headers = [
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Material Code','sort'=>'item_code'],    			 
    			['name'=>'Total Quantity','sort'=>'quantity'],    			    		
    	];
    	
    	return $headers;
    }
    
    
    /**
     * Get replenishment adjustment table headers
     * @return string[][]
     */
    public function getAdjustmentColumns()
    {
    	$headers = [
    			['name'=>'Segment Code','sort'=>'segment_code'],
    			['name'=>'Brand Name','sort'=>'brand_name'],
    			['name'=>'Material Description','sort'=>'description'],
    			['name'=>'Material Code','sort'=>'item_code'],    			 
    			['name'=>'Total Quantity','sort'=>'quantity'],
    	];
    	 
    	return $headers;
    }
    
    /**
     * Get Stock transfer column headers
     * @return string[][]
     */
    public function getStockAuditColumns()
    {
    	$headers = [
    			['name'=>'Area','sort'=>'area_name'],
    			['name'=>'Salesman','sort'=>'salesman_name'],
    			['name'=>'Canned & Mixes','sort'=>'canned'],
    			['name'=>'Frozen & Kassel','sort'=>'frozen'],
    			['name'=>'Period Covered'],
    			['name'=>'Statement No.', 'sort'=>'reference_number'],    			    
    	];
    	 
    	return $headers;
    }
    
    /**
     * Return STock transfer report columns
     * @return multitype:string
     */
    public function getStockAuditReportSelectColumns()
    {
    	return [
    			'area_name',
    			'salesman_name',
    			'canned',
    			'frozen',
    			'from',
    			'reference_number',    			
    	];
    }
    
    /**
     * Return STock transfer report columns
     * @return multitype:string
     */
    public function getStockTransferReportSelectColumns()
    {
    	return [
    			'stock_transfer_number',
    			'transfer_date',
    			'salesman_name',
    			'area_name',
    			'dest_van_code',
    			'segment_code',
    			'brand',
    			'item_code',
    			'description',
    			'uom_code',
    			'quantity'
    	];
    }
    
    /**
     * Get Stock transfer data report
     * @return \App\Core\PaginatorCore
     */
    public function getStockTransferReport()
    {
    	$prepare = $this->getPreparedStockTransfer();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();   
    	$data['total'] = $result->total();

        if(!empty($data['records'])){
            $open_close_period = PresenterFactory::getInstance('OpenClosingPeriod');
            foreach ($data['records'] as $key => $value) {
                $item_code_info = explode('_', $value->item_code);
                $year = date('Y',strtotime($value->transfer_date));
                $month = date('n',strtotime($value->transfer_date));
                $period_status = !empty($open_close_period->periodClosed($item_code_info[0],25,$month,$year)) ? 1 : 0;
                $data['records'][$key]->closed_period = $period_status;
            }
        }

    	return response()->json($data);
    }
    
    
    /**
     * Get Stock audit data report
     * @return \App\Core\PaginatorCore
     */
    public function getStockAuditReport()
    {
    	$prepare = $this->getPreparedStockAudit();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();

    	return response()->json($data);
    }
    
    
    /**
     * Get replenishment report report
     * @return \App\Core\PaginatorCore
     */
    public function getActualCountReport()
    {    	    	
    	$prepare = $this->getPreparedActualCount();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    	
    	$reference = '';
    	if($data['total'])
    	{
    		foreach($data['records'] as $row)
    		{
    			$reference = $row->reference_number;
    			break;
    		}
    	}
    	$data['reference_num'] = $reference;
    	return response()->json($data);
    }
    
    
    /**
     * Get replenishment adjustment report report
     * @return \App\Core\PaginatorCore
     */
    public function getAdjustmentReport()
    {
    	$prepare = $this->getPreparedAdjustment();
    	$result = $this->paginate($prepare);
    	$data['records'] = $result->items();
    	$data['total'] = $result->total();
    	 
    	$reference = '';
    	if($data['total'])
    	{
    		foreach($data['records'] as $row)
    		{
    			$reference = $row->reference_number;
    			break;
    		}
    	}
    	$data['reference_num'] = $reference;
    	return response()->json($data);
    }
    
    
    /**
     * Get Stock audit data report
     * @return \App\Core\PaginatorCore
     */
    public function getFlexiDealReport()
    {
    	$prepare = $this->getPreparedFlexiDeal();
    	$result = $this->paginate($prepare);    	
    	$data['records'] = PresenterFactory::getInstance('Reports')->validateInvoiceNumber($result->items());
    	$data['total'] = $result->total();
    	
    	$data['summary'] = '';
    	if($result->total())
    	{
    		$prepare = $this->getPreparedFlexiDeal(true);
    		$data['summary'] = $prepare->first();
    	}
    	
    	return response()->json($data);
    }
    
    
    /**
     * Get Prepared statement for stock transfer
     * @param string $summary
     * @return unknown
     */
    public function getPreparedFlexiDeal($summary=false)
    {
    	$select = '
    			app_area.area_name,
    			txn_sales_order_header.salesman_code,    			
    			app_salesman.salesman_name,
    			app_customer.customer_name,
				txn_sales_order_header.invoice_number,
    			txn_sales_order_header.so_date as invoice_date,
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
    			
				txn_item_flexi_deal.item_code,
    			regular.description as item_desc,
    			txn_item_flexi_deal.item_qty regular_order_qty,
    			txn_item_flexi_deal.trade_item_code,
    			deal.description as deal_item_desc,
    			txn_item_flexi_deal.trade_item_qty trade_order_qty,
    			ROUND(txn_item_flexi_deal.price*1.12,2) gross_order_amount,
    			IF(txn_sales_order_header.updated_by,\'modified\',IF(txn_sales_order_deal.updated_by,\'modified\',\'\')) updated
    			';
    	
    	if($summary)
    	{
    		$select = '
    			  SUM(txn_item_flexi_deal.item_qty) regular_order_qty,
    			  SUM(txn_item_flexi_deal.trade_item_qty) trade_order_qty,
			      SUM(txn_item_flexi_deal.price) gross_order_amount			      
    			';
    	}
    	 
    	$prepare = \DB::table('txn_sales_order_deal')
				    	->selectRaw($select)
				    	->leftJoin('txn_item_flexi_deal','txn_item_flexi_deal.deal_code','=','txn_sales_order_deal.deal_code')
				    	->leftJoin('txn_sales_order_header','txn_sales_order_header.reference_num','=','txn_sales_order_deal.reference_num')
				    	->leftJoin('app_salesman', function($join){
				    		$join->on('txn_sales_order_header.salesman_code','=','app_salesman.salesman_code');
				    		$join->where('app_salesman.status','=','A');
				    	})
				    	->leftJoin('app_item_master as regular','regular.item_code','=','txn_sales_order_deal.item_code')
				    	->leftJoin('app_item_master as deal','deal.item_code','=','txn_sales_order_deal.trade_item_code')
				    	->leftJoin('app_customer','txn_sales_order_header.customer_code','=','app_customer.customer_code')
				    	->leftJoin('app_area','app_customer.area_code','=','app_area.area_code');
    
    	 
    	if($this->isSalesman())
    	{
    		$prepare->where('txn_sales_order_header.salesman_code',auth()->user()->salesman_code);
    	}
    	else
    	{
    		$salesmanFilter = FilterFactory::getInstance('Select');
    		$prepare = $salesmanFilter->addFilter($prepare,'salesam_code',
    			function($self, $model){
    				return $model->where('txn_sales_order_header.salesman_code',$self->getValue());
    			});
    	}
    		
    	$companyCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('app_customer.customer_code','like',$self->getValue().'%');
    			});
    	 
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area_code',
    			function($self, $model){
    				return $model->where('app_customer.area_code','=',$self->getValue());
    			});    	 
    	 
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('txn_sales_order_deal.item_code','=',$self->getValue());
    			});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer_code',
    			function($self, $model){
    				return $model->where('txn_sales_order_header.customer_code',$self->getValue());
    			});
    	
    	$invoiceFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceFilter->addFilter($prepare,'invoice_date',function($self, $model){
    		return $model->whereBetween('txn_sales_order_header.so_date',$self->formatValues($self->getValue()));
    	});
    	 
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('txn_sales_order_header.so_date','desc');    		
    	}
    	 
    	 
//     	if(!$this->hasAdminRole() && auth()->user())
//     	{
//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
//     		$prepare->whereIn('salesman_area.area_code',$codes);
//     	}
    
    	return $prepare;
    }
    
    /**
     * Get prepared statement for stock audit
     * @return unknown
     */
    public function getPreparedStockAudit()
    {
    	$select = '
    			report_stock_audit.canned,
    			report_stock_audit.frozen,  
    			CONCAT(\'REPORT#\',report_references.reference_number) as reference_number,
    			report_references.from,
    			report_references.to,
    			rds_salesman.area_name,
    			rds_salesman.salesman_name
    			';
    	 
    	$prepare = \DB::table('report_stock_audit')
    						->selectRaw($select)
				    	->leftJoin('report_references','report_references.id','=','report_stock_audit.reference_id')
				    	->leftJoin('rds_salesman','rds_salesman.salesman_code','=','report_references.salesman');
    	    	
    	if($this->isSalesman())
    	{
    		$prepare->where('report_references.salesman_code',auth()->user()->salesman_code);
    	}
    	else
    	{
    		$salesmanFilter = FilterFactory::getInstance('Select');
    		$prepare = $salesmanFilter->addFilter($prepare,'salesman_code',
    				function($self, $model){
    					return $model->where('report_references.salesman',$self->getValue());
    				});
    	}
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('rds_salesman.area_name',$self->getValue());
    			});
    	
    	
    	$referenceFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceFilter->addFilter($prepare,'reference_number',
    			function($self, $model){
    				return $model->where('report_references.reference_number','like','%'.$self->getValue().'%');
    			});
    	
    	$monthlyFilter = FilterFactory::getInstance('Date');
    	$prepare = $monthlyFilter->addFilter($prepare,'month_from',
    			function($self, $model){
    				$from = (new Carbon($self->getValue()))->startOfMonth();
    				$to = (new Carbon($self->getValue()))->endOfMonth();    				
    				return $model->where(function($query) use($from,$to){
    					$query->whereBetween('report_references.from',[$from,$to]);
    					$query->whereBetween('report_references.to',[$from,$to]);
    				});
    			});
    	
    	$yearFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $yearFilter->addFilter($prepare,'yearly_from',
    			function($self, $model){
    				$from = (new Carbon($self->getValue()))->startOfYear();
    				$to = (new Carbon($self->getValue()))->endOfYear();
    				return $model->where(function($query) use($from,$to){
    					$query->whereBetween('report_references.from',[$from,$to]);
    					$query->whereBetween('report_references.to',[$from,$to]);
    				});
    			});

    	$periodFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $yearFilter->addFilter($prepare,'period',
    			function($self, $model){
    				$value = $self->getValue();
    				return $model->where(function($query) use($value){
    					$query->whereBetween('report_references.from',$value);
    					$query->whereBetween('report_references.to',$value);
    				});
    			});
    	
		$prepare->orderBy('report_references.reference_number','desc');

    	return $prepare;
    }
    
    /**
     * Get Prepared statement for stock transfer
     */
    public function getPreparedStockTransfer()
    {
    	$select = '
    			txn_stock_transfer_in_header.stock_transfer_in_header_id,
    			txn_stock_transfer_in_detail.stock_transfer_in_detail_id,
    			UPPER(txn_stock_transfer_in_header.stock_transfer_number) stock_transfer_number,
    			txn_stock_transfer_in_header.transfer_date,
    			txn_stock_transfer_in_header.dest_van_code,
				app_item_master.segment_code,
    			app_item_brand.description as brand,
    			txn_stock_transfer_in_detail.item_code,
				app_item_master.description,
    			app_item_uom.description as uom_code,
    			salesman_area.area_name,
    			salesman_area.salesman_name,
    			txn_stock_transfer_in_detail.quantity,
    			IF(txn_stock_transfer_in_header.updated_by,\'modified\',
	    			IF(txn_stock_transfer_in_detail.updated_by,\'modified\',\'\')
	    		) updated
    			';
    	
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->selectRaw($select)
					    ->leftJoin('txn_stock_transfer_in_detail','txn_stock_transfer_in_header.stock_transfer_number','=','txn_stock_transfer_in_detail.stock_transfer_number')
					    ->leftJoin('app_item_master','app_item_master.item_code','=','txn_stock_transfer_in_detail.item_code')
					    ->leftJoin('app_item_brand','app_item_master.brand_code','=','app_item_brand.brand_code')
					    ->leftJoin('app_item_uom','txn_stock_transfer_in_detail.uom_code','=','app_item_uom.uom_code')
					    ->leftJoin(\DB::raw('
			    			(select apsc.salesman_code,aps.salesman_name,ac.area_code, aa.area_name from app_salesman_customer apsc
					    	 join app_customer ac on ac.customer_code = apsc.customer_code
					    	 join app_salesman aps on apsc.salesman_code=aps.salesman_code
					    	 join app_area aa on aa.area_code = ac.area_code
					    	 where aps.status = \'A\'
							group by apsc.salesman_code) salesman_area'), function($join){
					    		$join->on('txn_stock_transfer_in_header.salesman_code','=','salesman_area.salesman_code');
						});
    	 
    	
		if($this->isSalesman())
		{
			$prepare->where('txn_stock_transfer_in_header.salesman_code',auth()->user()->salesman_code);
		}
		else
		{
			$salesmanFilter = FilterFactory::getInstance('Select');
			$prepare = $salesmanFilter->addFilter($prepare,'salesman_code');
		}
					    
    	$companyCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('txn_stock_transfer_in_detail.item_code','like',$self->getValue().'%');
    			});
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('salesman_area.area_code','=',$self->getValue());
    			});
    	
    	$segmentFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentFilter->addFilter($prepare,'segment',
    			function($self, $model){
    				return $model->where('app_item_master.segment_code','=',$self->getValue());
    			});
    	
    	
    	$transferDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $transferDateFilter->addFilter($prepare,'transfer_date');
    	
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('txn_stock_transfer_in_detail.item_code','=',$self->getValue());
    			});
    	
    	$stockTransferFilter = FilterFactory::getInstance('Text');
    	$prepare = $stockTransferFilter->addFilter($prepare,'stock_transfer_number');
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('txn_stock_transfer_in_header.transfer_date','desc');
    		$prepare->orderBy('txn_stock_transfer_in_header.stock_transfer_number');
    	}
    	
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$reportsPresenter = PresenterFactory::getInstance('Reports');
    		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('salesman_area.area_code',$codes);
    	}
    	    	
    	return $prepare;
    }
    
    /**
     * Get Prepared statement for stock transfer
     */
    public function getPreparedActualCount()
    {
    	$select = '
    			replenishment.reference_number,
    			replenishment_item.item_code,
    			app_item_master.description,
    			replenishment_item.quantity,
    			\'\' updated
    			';
    	 
    	$prepare = \DB::table('replenishment')
    					->selectRaw($select)
    					->leftJoin('replenishment_item','replenishment_item.reference_number','=','replenishment.reference_number')				    	
				    	->leftJoin('app_item_master','app_item_master.item_code','=','replenishment_item.item_code');				    	
    	
    	 
    	if($this->isSalesman())
    	{
    		$vanCode = $this->getSalesmanVan(auth()->user()->salesman_code);
    		$prepare->whereIn('replenishment.van_code',$vanCode);
    	}
    	else
    	{
    		if($this->request->get('salesman_code'))
    		{
	    		$vanCode = $this->getSalesmanVan($this->request->get('salesman_code'));
	    		$prepare->whereIn('replenishment.van_code',$vanCode);
    		}
    	}
    	
    	$replenishmentDateFilter = FilterFactory::getInstance('Date');
    	$prepare = $replenishmentDateFilter->addFilter($prepare,'replenishment_date_from',
    			function($self, $model){
    				return $model->where(DB::raw('DATE(replenishment.replenishment_date)'),format_date($self->getValue(), 'Y-m-d'));
    			});
    	 
    	$referenceFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceFilter->addFilter($prepare,'reference_number');
    	 
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('replenishment.replenishment_date','desc');    		
    	}    	
    	
    	$prepare->whereNull('replenishment.deleted_at');
    	$prepare->where('replenishment.type',Replenishment::ACTUAL_COUNT_TYPE);
    	
//     	if(!$this->hasAdminRole() && auth()->user())
//     	{
//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
//     		$prepare->whereIn('salesman_area.area_code',$codes);
//     	}

		if(!$this->request->get('salesman_code') && !$this->request->get('replenishment_date_from') && !$this->request->get('reference_number'))
			return $prepare->where('replenishment.id',0);
    		
    	return $prepare;
    }
    
    
    /**
     * Get Prepared statement for stock transfer
     */
    public function getPreparedAdjustment()
    {
    	$select = '
    			replenishment.reference_number,
    			replenishment_item.item_code,
    			app_item_master.segment_code,
    			app_item_master.description,
    			replenishment_item.quantity,
    			app_item_brand.description as brand_name,
    			\'\' updated
    			';
    
    	$prepare = \DB::table('replenishment')
				    	->selectRaw($select)
				    	->leftJoin('replenishment_item','replenishment_item.reference_number','=','replenishment.reference_number')
				    	->leftJoin('app_item_brand','replenishment_item.brand_code','=','app_item_brand.brand_code')
				    	->leftJoin('app_item_master','app_item_master.item_code','=','replenishment_item.item_code');
    	 
    
    	if($this->isSalesman())
    	{
    		$prepare->where('replenishment.modified_by',auth()->user()->salesman_code);
    	}
    	else
    	{
    		if($salesman = $this->request->get('salesman_code'))
    		{
    			$prepare->where('replenishment.modified_by', $salesman);
    		}
    	}
    	 
    	$replenishmentDateFilter = FilterFactory::getInstance('Date');
    	$prepare = $replenishmentDateFilter->addFilter($prepare,'replenishment_date_from',
    			function($self, $model){
    				return $model->where(DB::raw('DATE(replenishment.replenishment_date)'),format_date($self->getValue(), 'Y-m-d'));
    			});
    
    	$referenceFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceFilter->addFilter($prepare,'reference_number');
    
    	$reasonFilter = FilterFactory::getInstance('Text');
    	$prepare = $reasonFilter->addFilter($prepare,'adjustment_reason');
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('replenishment.replenishment_date','desc');
    	}
    	 
    	$prepare->whereNull('replenishment.deleted_at');
    	$prepare->where('replenishment.type',Replenishment::REPLENISHMENT_TYPE);
    	 
    	//     	if(!$this->hasAdminRole() && auth()->user())
    		//     	{
    		//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
    		//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		//     		$prepare->whereIn('salesman_area.area_code',$codes);
    		//     	}
    
    	if(!$this->request->get('salesman_code') && !$this->request->get('replenishment_date_from') && !$this->request->get('reference_number'))
    		return $prepare->where('replenishment.id',0);
    
    	return $prepare;
    }
    
    
    /**
     * Get Flexi deal filter data
     * @return string[]|unknown[]
     */
    public function getFlexiDealFilterData()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportsPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area_code') ? $reportsPresenter->getArea()[$this->request->get('area_code')] : 'All';
    	$company_code = $this->request->get('company_code') ? $reportsPresenter->getCompanyCode()[$this->request->get('company_code')] : 'All';
    	$customer = $this->request->get('customer_code') ? $reportsPresenter->getCustomer(false)[$this->request->get('customer_code')] : 'All';
    	$invoice_date = ($this->request->get('invoice_date_from') && $this->request->get('invoice_date_to')) ? $this->request->get('invoice_date_from').' - '.$this->request->get('invoice_date_to') : 'All';
    	$item = $this->request->get('item_code') ? $this->request->get('item_code') : 'All';
    
    	$filters = [
    			'Salesman' => $salesman,
    			'Company Code' => $company_code,
    			'Area' => $area,    			
    			'Customer' => $customer,
    			'Invoice Date' => $invoice_date,
    			'Regular Item Code' => $item,    			
    	];
    	return $filters;
    }
    
    /**
     * Get stock transfer filter data
     */
    public function getStockAuditFilterData()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportsPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area') ? $this->request->get('area') : 'All';    	
    	$month = $this->request->get('month_from') ? (new Carbon($this->request->get('month_from')))->format('F') : '';    	
    	$year = $this->request->get('year_from') ? (new Carbon($this->request->get('year_from')))->format('Y') : '';
    	$period = ($this->request->get('period_from') && $this->request->get('period_to')) ? $this->request->get('period_from').' - '.$this->request->get('period_to') : 'All';
    	$reference = $this->request->get('reference_number');
    	 
    	$filters = [
    			'Salesman' => $salesman,    			
    			'Area' => $area,
    			'Month' => $month,
    			'Year' => $year,
    			'Period Covered' => $period,
    			'Statement No.' => $reference,
    	];
    	return $filters;
    }
    
    /**
     * Get stock transfer filter data
     */
    public function getStockTransferFilterData()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportsPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area') ? $reportsPresenter->getArea()[$this->request->get('area')] : 'All';   
    	$company_code = $this->request->get('company_code') ? $reportsPresenter->getCompanyCode()[$this->request->get('company_code')] : 'All';
    	$material = $this->request->get('item_code') ? $reportsPresenter->getItems()[$this->request->get('item_code')] : 'All';
    	$segment = $this->request->get('segment') ? $reportsPresenter->getItemSegmentCode()[$this->request->get('segment')] : 'All';
    	$transferDate = ($this->request->get('transfer_date_from') && $this->request->get('transfer_date_to')) ? $this->request->get('transfer_date_from').' - '.$this->request->get('transfer_date_to') : 'All';    	
    	$stockTransferNum = $this->request->get('stock_transfer_number');
    	
    	$filters = [
    			'Salesman' => $salesman,    			    		
    			'Company Code' => $company_code,
    			'Area' => $area,
    			'Segment' => $segment,
    			'Material' => $material,    			
    			'Stock Transfer Date' => $transferDate,
    			'Stock Transfer No.' => $stockTransferNum,
    	];
    	return $filters;
    }

    
    /**
     * Get item codes
     * @return unknown
     */
    public function getItemCodes()
    {
		return DB::table('app_item_master')
					->where('status','A')
					->orderBy('item_code')
					->lists('item_code','item_code');
    }
    
    /**
     * Get item codes
     * @return unknown
     */
    public function getUom()
    {
    	return DB::table('app_item_uom')
    	->where('status','A')
    	->orderBy('uom_code')
    	->lists('description','uom_code');
    }
    
    
    /**
     * Get item brands
     * @return unknown
     */
    public function getBrands()
    {
    	return DB::table('app_item_brand')
    			->where('status','A')
		    	->orderBy('description')
		    	->lists('description','brand_code');
    }
    
    
    /**
     * Export Statement of Shortages and Overages Per Salesman 	
     * @param string $type
     * @return unknown
     */
    public function exportShortageOverages($type='canned')
    {    	
    	
		$reportsPresenter = PresenterFactory::getInstance('Reports');    			
    	$params = $this->request->all();
    	$from = (new Carbon($params['transaction_date_from']))->startOfDay();
    	$to = (new Carbon($params['transaction_date_to']))->endOfDay();

    	// Beginning Balance / Actual Count
    	// Get Replenishment data
    	$prepare = \DB::table('txn_replenishment_header')
					    	->selectRaw('replenishment_date, UPPER(reference_number) reference_number')
					    	->leftJoin('app_salesman_van', function($join){
					    		$join->on('app_salesman_van.van_code','=','txn_replenishment_header.van_code');
					    		$join->where('app_salesman_van.status','=','A');
					    	});
    		 
    	$prepare->whereBetween('txn_replenishment_header.replenishment_date',[$from,$to]);
    	$prepare->orderBy('txn_replenishment_header.replenishment_date','desc');
    	$prepare->orderBy('txn_replenishment_header.replenishment_header_id','desc');
    		 
    	$referenceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $referenceNumFilter->addFilter($prepare,'reference_number');
    		 
    	if($this->request->has('salesman_code'))
    		$prepare = $prepare->where('app_salesman_van.salesman_code','=',$this->request->get('salesman_code'));
    	
    	$replenishment = $prepare->first();
    	
    	$salesman = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$this->request->get('salesman_code'))->first();
    	
    	$records = [];
    	$overages = [];
    	$shortages = [];
    	
    	if($replenishment)
    	{
    		$replenishment = new Carbon($replenishment->replenishment_date);    		
    		$params['transaction_date'] = $replenishment->format('Y/m/d');
    		$this->request->replace($params);
	    	$records = $reportsPresenter->getVanInventory(true);	    	
	    	if($records)
	    	{
	    		array_pop($records);
	    		$shortOver = array_pop($records);	    		
	    		$actualCount =  array_pop($records);
	    		$stockOnHand =  array_pop($records);
	    		if($shortOver)
	    		{
	    			array_shift($shortOver);
	    			$short = collect($shortOver)->filter(function ($value) {
									    		return $value < 0;
										})->all();	    								
									
					$shortItemCodes = [];					
					if($short)
					{
						foreach($short as $code=>$val)
						{
							$itemCode = str_replace('code_', '', $code);
							$shortages[$itemCode]['short_over'] = $val;
							$shortages[$itemCode]['stock_on_hand'] = isset($stockOnHand[$code]) ? $stockOnHand[$code] : 0;
							$shortages[$itemCode]['actual_count'] = isset($actualCount[$code]) ? $actualCount[$code] : 0;
							$shortItemCodes[] = $itemCode;
						}
						if($shortItemCodes)
						{
							$items = $this->getItemDetails($shortItemCodes, $salesman->area_code);
							if($items)
							{
								foreach($items as $item)
								{
									$shortages[$item->item_code]['item_code'] = $item->item_code;									
									$shortages[$item->item_code]['description'] = $item->description;
									$shortages[$item->item_code]['price'] = $item->unit_price;
									$shortages[$item->item_code]['total_amount'] = bcmul($shortages[$itemCode]['short_over'], $item->unit_price, 2) ;
								}
							}
							$shortages = collect($shortages);
						}
					}
					
					$over = collect($shortOver)->filter(function ($value) {
										return $value > 0;
								})->all();								
					$overItemCodes = [];
					if($over)
					{
						foreach($over as $code=>$val)
						{
							$itemCode = str_replace('code_', '', $code);
							$overages[$itemCode]['short_over'] = $val;
							$overages[$itemCode]['stock_on_hand'] = isset($stockOnHand[$code]) ? $stockOnHand[$code] : 0;
							$overages[$itemCode]['actual_count'] = isset($actualCount[$code]) ? $actualCount[$code] : 0;							
							$overItemCodes[] = $itemCode;
						}
						if($overItemCodes)
						{
							$items = $this->getItemDetails($overItemCodes,$salesman->area_code);
							if($items)
							{
								foreach($items as $item)
								{
									$overages[$item->item_code]['item_code'] = $item->item_code;
									$overages[$item->item_code]['description'] = $item->description;
									$overages[$item->item_code]['price'] = $item->unit_price;
									$overages[$item->item_code]['total_amount'] = bcmul($overages[$item->item_code]['short_over'], $item->unit_price, 2) ;
								}
							}
							$overages = collect($overages);
						}
					}
	    			
	    		}
	    	}
    	}

    	
    	$ref = '';
    	$report = 'vaninventory'.$type;
    	if($shortages || $overages)
    	{
    		add_ref($report, $from, $to,$this->request->get('salesman_code'));
    		$ref = get_ref($report, $from, $to,$this->request->get('salesman_code'));
    		if($ref)
    		{
    			$totalShortages = $shortages ? $shortages->sum('total_amount') : 0;
    			$totalOverages = $overages ? $overages->sum('total_amount') : 0;
    			$total = bcadd($totalShortages,$totalOverages,2);
    			$audit = ModelFactory::getInstance('ReportStockAudit');
    			if($type == 'canned')
    				$audit->canned = $total;
    			else 
    				$audit->frozen = $total;
    			$audit->reference_id = $ref->id;
    			$audit->save();
    		}
    	}

//     	$this->view->ref = get_ref('vaninventory'.$type, $from, $to,$this->request->get('salesman_code'));    	
//     	$this->view->type = ($type == 'canned') ? 'CANNED & MIXES' : 'FROZEN & KASSEL';
//     	$this->view->overages = $overages;
//     	$this->view->shortages = $shortages;
//     	$salesman = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$this->request->get('salesman_code'))->first();
//     	$this->view->salesman = $salesman ? $salesman->salesman_name : '';    	
//     	$this->view->jrSalesman = $salesman ? $salesman->jr_salesman_name : '';
//     	$this->view->area = $salesman ? $salesman->area_name : '';
//     	$auditor = ModelFactory::getInstance('User')->find($this->request->get('audited_by'));
//     	$this->view->auditor = $auditor ? $auditor->formal_name : '';
//     	$this->view->auditorArea = $auditor->area ? trim(str_replace('SFI','',$auditor->area->area_name)) : '';    	
//     	return $this->view('shortagesPdf');
    	    	
    	$auditor = ModelFactory::getInstance('User')->find($this->request->get('audited_by'));
    	$params['type'] = ($type == 'canned') ? 'CANNED & MIXES' : 'FROZEN & KASSEL';
    	$params['auditor'] = $auditor ? $auditor->formal_name : '';
    	if($salesman)
    	{
    		$params['salesman'] = $salesman->salesman ? $salesman->salesman->salesman_name : $salesman->salesman_name;
    	}
    	$params['jrSalesman'] = $salesman ? $salesman->jr_salesman_name : '';
    	$params['area'] = $salesman ? $salesman->area_name : '';
    	$params['auditorArea'] = $auditor->area ? trim(str_replace('SFI','',$auditor->area->area_name)) : '';
    	$params['shortages'] = $shortages;
    	$params['overages'] = $overages;
    	$params['ref'] = $ref;

    	$pdf = \PDF::loadView('VanInventory.shortagesPdf',$params)->setPaper('folio')->setOrientation('portrait');   
    	return $pdf->download('Van Inventory and History Report Statement of Shortages and Overages.pdf');
    }
    
    /**
     * Get Item details
     * @param unknown $itemCodes
     * @return unknown
     */
    public function getItemDetails($itemCodes,$areaCode)
    {
    	return DB::table('app_item_master')
			    	->select(['app_item_master.description','app_item_master.item_code',DB::raw('coalesce(app_item_price.unit_price,0) unit_price')])
			    	->leftJoin('app_item_price',function($join){
			    		$join->on('app_item_price.item_code','=','app_item_master.item_code');
			    		$join->where('app_item_price.uom_code','=','PCS');
			    		$join->where('app_item_price.status','=','A');
			    	})
			    	->leftJoin('app_customer',function($join) use ($areaCode){
			    		$join->on('app_customer.customer_price_group','=','app_item_price.customer_price_group');
			    		$join->where('app_customer.area_code','=',$areaCode);
			    	})
			    	///->leftJoin('app_customer','app_customer.customer_price_group','=','app_item_price.customer_price_group')
			    	->whereIn('app_item_master.item_code',$itemCodes)			    	
			    	->get();
    }
    
    
    /**
     * Get Salesman Van
     * @param unknown $salesmanCode
     * @return unknown
     */
    public function getSalesmanVan($salesmanCode)
    {
    	$prepare = DB::table('app_salesman')
    					->leftJoin('app_salesman_van',function($join){
    						$join->on('app_salesman_van.salesman_code','=','app_salesman.salesman_code');		
    						$join->where('app_salesman_van.status','=','A');
    					})
    					->where('app_salesman.salesman_code',$salesmanCode);
    	
    	return $prepare->lists('van_code');
    }
    
    
    /**
     * Get van codes
     * @return unknown
     */
    public function getVanCodes()
    {
    	$prepare = DB::table('app_salesman_van')
    				->leftJoin('app_salesman','app_salesman_van.salesman_code','=','app_salesman.salesman_code')
    				->where('app_salesman.status','A')
    				->where('app_salesman_van.status','A');    	 
    	return $prepare->lists('app_salesman_van.van_code','app_salesman.salesman_code');
    }
        
    /**
     * Get Jr Salesman
     * @return unknown
     */
    public function getJrSalesman()
    {
    	$prepare = DB::table('rds_salesman')->where(DB::raw('LENGTH(jr_salesman_name)'),'>',0)->orderBy('jr_salesman_name');
    	return $prepare->lists('jr_salesman_name','salesman_code');
    }
    
    
    /**
     * Get replenishment
     * @param unknown $referenceNum
     * @return unknown
     */
    public function getReplenishment($referenceNum)
    {
    	return DB::table('replenishment')->where('reference_number',$referenceNum)->first();	
    }
    
    /**
     * Export replenishment data
     * @param unknown $type
     * @return unknown
     */
    public function exportActualCount($type)
    {    	
    	$prepare = $this->getPreparedActualCount();
    	
    	if($type == 'pdf')
    		$prepare->where('replenishment_item.quantity','>',0);
    	
    	$replenishment = new \stdClass();
    	
    	$replenishment->salesman = sr_salesman($this->request->get('salesman_code'));
    	$replenishment->jr_salesman = jr_salesman($this->request->get('salesman_code'));
    	$replenishment->van_code = salesman_van($this->request->get('salesman_code'));    	
    	$replenishment->items = $prepare->get();
    	$replenishment->replenish_date = (new Carbon($this->request->get('replenishment_date_from')))->toDateTimeString();
    	$replenishment->replenish = $this->getReplenishment($this->request->get('reference_number'));
    	
//     	$this->view->replenishment = $replenishment;
//     	return $this->view('replenishmentExport');
    	
    	if(in_array($type,['xls','xlsx']))
    	{
    		\Excel::create('Actual Count Replenishment Report', function($excel) use ($replenishment){
    			$excel->sheet('Sheet1', function($sheet) use ($replenishment){    				
    				$sheet->loadView('VanInventory.actualCountXlsExport',compact('replenishment'));
    			});
    	
    		})->export($type);
    	}
    	elseif($type == 'pdf')
    	{    		
    		$pdf = \PDF::loadView('VanInventory.actualCountPdfExport', compact('replenishment'))->setPaper('folio')->setOrientation('portrait');;    		
    		return $pdf->download('Actual Count Replenishment Report.pdf');
    	}
    }
    
    
    /**
     * Export replenishment adjustment data
     * @param unknown $type
     * @return unknown
     */
    public function exportAdjustment($type)
    {
    	$prepare = $this->getPreparedAdjustment();
    	 
    	if($type == 'pdf')
    		$prepare->where('replenishment_item.quantity','>',0);
    		 
    		$replenishment = new \stdClass();
    		 
    		$replenishment->salesman = sr_salesman($this->request->get('salesman_code'));
    		$replenishment->jr_salesman = jr_salesman($this->request->get('salesman_code'));
    		$replenishment->van_code = salesman_van($this->request->get('salesman_code'));
    		$replenishment->items = $prepare->get();
    		$replenishment->replenish_date = (new Carbon($this->request->get('replenishment_date_from')))->toDateTimeString();
    		$replenishment->replenish = $this->getReplenishment($this->request->get('reference_number'));
    		 
    		//     	$this->view->replenishment = $replenishment;
    		//     	return $this->view('replenishmentExport');
    		 
    		if(in_array($type,['xls','xlsx']))
    		{
    			\Excel::create('Adjustment Replenishment Report', function($excel) use ($replenishment){
    				$excel->sheet('Sheet1', function($sheet) use ($replenishment){
    					$sheet->loadView('VanInventory.adjustmentXlsExport',compact('replenishment'));
    				});
    					 
    			})->export($type);
    		}
    		elseif($type == 'pdf')
    		{
    			$pdf = \PDF::loadView('VanInventory.adjustmentPdfExport', compact('replenishment'))->setPaper('folio')->setOrientation('portrait');;
    			return $pdf->download('Adjustment Replenishment Report.pdf');
    		}
    }
    
}
