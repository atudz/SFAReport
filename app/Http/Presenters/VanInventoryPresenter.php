<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;
use App\Factories\FilterFactory;

class VanInventoryPresenter extends PresenterCore
{
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
    			['name'=>'Stock Transfer #','sort'=>'stock_transfer_number'],
    			['name'=>'Transaction Date','sort'=>'transfer_date'],
    			['name'=>'From Loc/Van Salesman','sort'=>'dest_van_code'],    			
    			['name'=>'Segment','sort'=>'segment_code'],
    			['name'=>'Brand','sort'=>'brand'],
    			['name'=>'Item Code','sort'=>'item_code'],
    			['name'=>'Item Description','sort'=>'description'],
    			['name'=>'UOM','sort'=>'uom_code'],
    			['name'=>'Qty','sort'=>'quantity'],
    		
    	];
    	
    	return $headers;
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
    	return response()->json($data);
    }
    
    /**
     * Get Prepared statement for stock transfer
     */
    public function getPreparedStockTransfer()
    {
    	$select = '
    			txn_stock_transfer_in_header.stock_transfer_number,
    			txn_stock_transfer_in_header.transfer_date,
    			txn_stock_transfer_in_header.dest_van_code,
				app_item_master.segment_code,
    			app_item_brand.description as brand,
    			txn_stock_transfer_in_detail.item_code,
				app_item_master.description,
    			txn_stock_transfer_in_detail.uom_code,
    			txn_stock_transfer_in_detail.quantity
    			';
    	
    	$prepare = \DB::table('txn_stock_transfer_in_header')
    					->selectRaw($select)
					    ->leftJoin('txn_stock_transfer_in_detail','txn_stock_transfer_in_header.stock_transfer_number','=','txn_stock_transfer_in_detail.stock_transfer_number')
					    ->leftJoin('app_item_master','app_item_master.item_code','=','txn_stock_transfer_in_detail.item_code')
					    ->leftJoin('app_item_brand','app_item_master.brand_code','=','app_item_brand.brand_code')
					    ->leftJoin('app_salesman_customer','app_salesman_customer.salesman_code','=','txn_stock_transfer_in_header.salesman_code')
					    ->leftJoin('app_customer','app_customer.customer_code','=','app_salesman_customer.customer_code');
    	 
    	
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
    				return $model->where('app_customer.area_code','=',$self->getValue());
    			});
    	
    	$segmentFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentFilter->addFilter($prepare,'segment',
    			function($self, $model){
    				return $model->where('app_item_master.segment_code','=',$self->getValue());
    			});
    	
    	
    	$transferDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $transferDateFilter->addFilter($prepare,'transfer_date');
    	
    	$segmentFilter = FilterFactory::getInstance('Select');
    	$prepare = $segmentFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('txn_stock_transfer_in_detail.item_code','=',$self->getValue());
    			});
    	
    	$stockTransferFilter = FilterFactory::getInstance('Text');
    	$prepare = $stockTransferFilter->addFilter($prepare,'stock_transfer_number');
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('txn_stock_transfer_in_header.transfer_date','desc');
    	}
    	    	
    	return $prepare;
    }

}
