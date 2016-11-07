<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;
use DB;
use App\Http\Requests\StockTransferRequest;
use Carbon\Carbon;
use App\Factories\ModelFactory;

class VanInventoryPresenter extends PresenterCore
{
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function create()
	{
		$reportsPresenter = PresenterFactory::getInstance('Reports');
		$this->view->itemCodes = $this->getItemCodes();
		$this->view->items = $reportsPresenter->getItems();
		$this->view->segments = $reportsPresenter->getItemSegmentCode();
		$this->view->brands = $this->getBrands();
		$this->view->uom = $this->getUom();
		$this->view->salesman = $reportsPresenter->getSalesman(true);
		return $this->view('add');
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
     * Get Stock transfer column headers
     * @return string[][]
     */
    public function getStockTransferColumns()
    {
    	$headers = [    			
    			['name'=>'Stock Transfer No.','sort'=>'stock_transfer_number'],
    			['name'=>'Transaction Date','sort'=>'transfer_date'],
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
    			'period',
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
    	
//     	$referenceFilter = FilterFactory::getInstance('Text');
//     	$prepare = $referenceFilter->addFilter($prepare,'reference_number',
//     			function($self, $model){
//     				return $model->where('report_references.reference_number','like','%'.$self->getValue().'%');
//     			});
    	
//     	if(!$this->hasAdminRole() && auth()->user())
//     	{
//     		$reportsPresenter = PresenterFactory::getInstance('Reports');
//     		$codes = $reportsPresenter->getAlikeAreaCode(auth()->user()->location_assignment_code);
//     		$prepare->whereIn('salesman_area.area_code',$codes);
//     	}

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
			    			(select apsc.salesman_code,ac.area_code from app_salesman_customer apsc
					    	 join app_customer ac on ac.customer_code = apsc.customer_code
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
     * Get stock transfer filter data
     */
    public function getStockAuditFilterData()
    {
    	$reportsPresenter = PresenterFactory::getInstance('Reports');
    	$salesman = $this->request->get('salesman_code') ? $salesman = $reportsPresenter->getSalesman()[$this->request->get('salesman_code')] : 'All';
    	$area = $this->request->get('area') ? $this->request->get('area') : 'All';    	
    	$month = $this->request->get('item_code') ? $reportsPresenter->getItems()[$this->request->get('item_code')] : 'All';
    	$year = $this->request->get('segment') ? $reportsPresenter->getItemSegmentCode()[$this->request->get('segment')] : 'All';
    	$period = ($this->request->get('period_from') && $this->request->get('period_to')) ? $this->request->get('period_from').' - '.$this->request->get('period_to') : 'All';
    	$reference = $this->request->get('reference_number');
    	 
    	$filters = [
    			'Salesman' => $salesman,    			
    			'Area' => $area,
    			'Monthly' => $month,
    			'Yearly' => $year,
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
							$items = $this->getItemDetails($shortItemCodes);
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
							$items = $this->getItemDetails($overItemCodes);
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
    	
    	$salesman = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$this->request->get('salesman_code'))->first();
    	$auditor = ModelFactory::getInstance('User')->find($this->request->get('audited_by'));
    	$params['type'] = ($type == 'canned') ? 'CANNED & MIXES' : 'FROZEN & KASSEL';
    	$params['auditor'] = $auditor ? $auditor->formal_name : '';
    	$params['salesman'] = $salesman ? $salesman->salesman_name : '';
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
    public function getItemDetails($itemCodes)
    {
    	return DB::table('app_item_master')
			    	->select(['app_item_master.description','app_item_master.item_code','app_item_price.unit_price'])
			    	->leftJoin('app_item_price',function($join){
			    		$join->on('app_item_price.item_code','=','app_item_master.item_code');
			    		$join->where('app_item_price.uom_code','=','PCS');
			    		$join->where('app_item_price.status','=','A');
			    		$join->where('app_item_price.customer_price_group','=','PR01401120');
			    	})
			    	->whereIn('app_item_master.item_code',$itemCodes)
			    	->get();
    }
}
