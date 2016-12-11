<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Requests\StockTransferRequest;
use App\Factories\ModelFactory;
use Carbon\Carbon;
use App\Http\Requests\ReplenishmentRequest;
use App\Factories\PresenterFactory;
use DB;
use App\Http\Requests\ReplenishmentDelete;
use App\Http\Models\Replenishment;
use App\Http\Requests\AdjustmentRequest;
use App\Http\Requests\AdjustmentDelete;

class VanInventoryController extends ControllerCore
{

	/**
	 * Save stock transfer data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveStockTransfer(StockTransferRequest $request)
	{
		
		if($request->type)
		{
			$stockTransfer = ModelFactory::getInstance('TxnStockTransferInHeader')->where('stock_transfer_in_header_id',$request->stock_transfer_id)->first();
			if($stockTransfer)
			{
				//dd($stockTransfer->stock_transfer_number);
				$this->addStockTranserItem($request, $stockTransfer->stock_transfer_number);
			}
		}
		else
		{
			$nextPkId = ModelFactory::getInstance('TxnStockTransferInHeader')->max('stock_transfer_in_header_id');
			if($nextPkId >= config('system.custom_pk_start'))
				$nextPkId++;
			else
				$nextPkId = config('system.custom_pk_start');
			
			$stockTransfer = ModelFactory::getInstance('TxnStockTransferInHeader');
			$stockTransfer->stock_transfer_in_header_id = $nextPkId;
			$stockTransfer->stock_transfer_number = $request->stock_transfer_number;
			$stockTransfer->salesman_code = $request->salesman_code;
			$stockTransfer->dest_van_code = $request->dest_van_code;
			$stockTransfer->src_van_code = $request->src_van_code;
			$stockTransfer->modified_by = $request->salesman_code;
			$stockTransfer->modified_date = new Carbon($request->transfer_date_from);
			$stockTransfer->sfa_modified_date = new \DateTime();
			$stockTransfer->status = 'P';
			//$stockTransfer->device_code = $request->device_code;
			$stockTransfer->updated_by  = auth()->user()->id;
			$stockTransfer->updated_at  = new \DateTime();
			$stockTransfer->transfer_date = new Carbon($request->transfer_date_from);
			
			if($stockTransfer->save())
			{
				$this->addStockTranserItem($request,$request->stock_transfer_number);
			}
			
		}
		
		return response()->json(['success'=>true]);
	}
	
	/**
	 * Add stock transfer Item
	 * @param StockTransferRequest $request
	 * @return unknown
	 */
	public function addStockTranserItem(StockTransferRequest $request, $reference)
	{
		$nextPkId = ModelFactory::getInstance('TxnStockTransferInDetail')->max('stock_transfer_in_detail_id');
		if($nextPkId >= config('system.custom_pk_start'))
			$nextPkId++;
		else
			$nextPkId = config('system.custom_pk_start');
				
		$stockDetail = ModelFactory::getInstance('TxnStockTransferInDetail');
		$stockDetail->stock_transfer_in_detail_id = $nextPkId;
		$stockDetail->stock_transfer_number = $reference;
		$stockDetail->item_code = $request->item_code;
		$stockDetail->quantity = $request->quantity;
		$stockDetail->uom_code = $request->uom_code;		
		$stockDetail->status = 'P';
		$stockDetail->device_code = $request->device_code;
		$stockDetail->updated_by  = auth()->user()->id;
		$stockDetail->updated_at  = new \DateTime();
		$stockDetail->modified_by = $request->salesman_code;
		$stockDetail->modified_date = new Carbon($request->transfer_date_from);
		$stockDetail->sfa_modified_date = new Carbon($request->transfer_date_from);
		return $stockDetail->save();
	}
	
	/**
	 * Save replenishment
	 * @param ReplenishmentRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveReplenishment(ReplenishmentRequest $request)
	{		
		DB::beginTransaction();
		
		$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
		
		$vans = $vanInventoryPresenter->getSalesmanVan($request->salesman_code);
		$replenish = ModelFactory::getInstance('Replenishment')->findOrNew((int)$request->id);		
		$replenish->van_code = $vans ? array_shift($vans) : '';
		$replenish->replenishment_date = new Carbon($request->replenishment_date_from);
		
		$today = new Carbon();
		$replenish->modified_date = $today;
		$replenish->sfa_modified_date = $today;
		$replenish->modified_by = $request->salesman_code;
		$replenish->type = Replenishment::ACTUAL_COUNT_TYPE;
		
		$replenish->fill($request->all());
		
		if($replenish->save())
		{
			$items = $request->get('item_code');
			$qty = $request->get('quantity');
			
			if($items && $qty)
			{
				ModelFactory::getInstance('ReplenishmentItem')
					->where('reference_number',$replenish->reference_number)
					->delete();
					
				foreach($items as $k=>$item)
				{						
					$detail = ModelFactory::getInstance('ReplenishmentItem');					
					$detail->reference_number = $replenish->reference_number;			
					$detail->item_code = $item;
					$detail->quantity = isset($qty[$k]) ? $qty[$k] : 0;
					$detail->uom_code = 'PCS';			
					$detail->status = 'A';			
					$detail->modified_by = $request->salesman_code;
					$detail->modified_date = new Carbon();
					$detail->sfa_modified_date = new Carbon();
					if(!$detail->save())
					{
						DB::rollback();
						return response()->json(['success'=>false]);						
					}
				}
			}
		}
		
		DB::commit();
		
		return response()->json(['success'=>true]);
		
		
	}
	
	/**
	 * Delete replishment
	 * @param ReplenishmentDelete $request
	 * @param unknown $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteReplenishment(ReplenishmentDelete $request, $id)
	{
		
		$replenish = ModelFactory::getInstance('Replenishment')->find($id);
		if($replenish)
		{
			$replenish->remarks = $request->remarks;
			$replenish->save();
			
			if($replenish->delete())
			{
				ModelFactory::getInstance('ReplenishmentItem')
							->where('reference_number',$replenish->reference_number)
							->delete();
			}
		}
		
		return response()->json(['success'=>true]);
	}
	
	
	/**
	 * Save replenishment adjustment
	 * @param ReplenishmentRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveAdjustment(AdjustmentRequest $request)
	{
		DB::beginTransaction();
	
		$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
	
		$vans = $vanInventoryPresenter->getSalesmanVan($request->salesman_code);
		$replenish = ModelFactory::getInstance('Replenishment')->findOrNew((int)$request->id);
		$replenish->van_code = $vans ? array_shift($vans) : '';
		$replenish->replenishment_date = new Carbon($request->replenishment_date_from);
		$replenish->adjustment_reason = $request->adjustment_reason;
	
		$today = new Carbon();
		$replenish->modified_date = $today;
		$replenish->sfa_modified_date = $today;
		$replenish->modified_by = $request->salesman_code;
		$replenish->type = Replenishment::REPLENISHMENT_TYPE;
	
		$replenish->fill($request->all());
	
		if($replenish->save())
		{
			$items = $request->get('item_code');
			$qty = $request->get('quantity');
			$brands = $request->get('brands');
				
			if($items && $qty)
			{
				ModelFactory::getInstance('ReplenishmentItem')
						->where('reference_number',$replenish->reference_number)
						->delete();
					
				foreach($items as $k=>$item)
				{
					$detail = ModelFactory::getInstance('ReplenishmentItem');
					$detail->reference_number = $replenish->reference_number;
					$detail->item_code = $item;
					$detail->brand_code = isset($brands[$k]) ? $brands[$k] : null;
					$detail->quantity = isset($qty[$k]) ? $qty[$k] : 0;
					$detail->uom_code = 'PCS';
					$detail->status = 'A';
					$detail->modified_by = $request->salesman_code;
					$detail->modified_date = new Carbon();
					$detail->sfa_modified_date = new Carbon();
					if(!$detail->save())
					{
						DB::rollback();
						return response()->json(['success'=>false]);
					}
				}
			}
		}
	
		DB::commit();
	
		return response()->json(['success'=>true]);
	
	
	}
	
	/**
	 * Delete replishment
	 * @param ReplenishmentDelete $request
	 * @param unknown $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteAdjustment(AdjustmentDelete $request, $id)
	{
	
		$replenish = ModelFactory::getInstance('Replenishment')->find($id);
		if($replenish)
		{
			$replenish->remarks = $request->remarks;
			$replenish->save();
				
			if($replenish->delete())
			{
				ModelFactory::getInstance('ReplenishmentItem')
				->where('reference_number',$replenish->reference_number)
				->delete();
			}
		}
	
		return response()->json(['success'=>true]);
	}
}
