<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;
use DB;
use App\Http\Requests\StockTransferRequest;

class VanInventoryPresenter extends PresenterCore
{
	/**
	 * Return van & inventory view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function create()
	{
// 		$reportsPresenter = PresenterFactory::getInstance('Reports');
// 		$this->view->companyCode = $reportsPresenter->getCompanyCode();
// 		$this->view->salesman = $reportsPresenter->getSalesman(true);
// 		$this->view->areas = $reportsPresenter->getArea();
// 		$this->view->items = $reportsPresenter->getItems();
// 		$this->view->segments = $reportsPresenter->getItemSegmentCode();
// 		$this->view->tableHeaders = $this->getStockTransferColumns();
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
			$prepare->where('app_salesman.salesman_code',auth()->user()->salesman_code);
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
    	    	
    	return $prepare;
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
    			'Stock Transer Date' => $transferDate,
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
}
