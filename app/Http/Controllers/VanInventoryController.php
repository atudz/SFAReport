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

class VanInventoryController extends ControllerCore
{

	/**
	 * Save stock transfer data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveStockTransfer(StockTransferRequest $request)
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
			$nextPkId = ModelFactory::getInstance('TxnStockTransferInDetail')->max('stock_transfer_in_detail_id');
			if($nextPkId >= config('system.custom_pk_start'))
				$nextPkId++;
			else
				$nextPkId = config('system.custom_pk_start');
				
			$stockDetail = ModelFactory::getInstance('TxnStockTransferInDetail');
			$stockDetail->stock_transfer_in_detail_id = $nextPkId;
			$stockDetail->stock_transfer_number = $request->stock_transfer_number;
			$stockDetail->item_code = $request->item_code;
			$stockDetail->quantity = $request->quantity;
			$stockDetail->uom_code = $request->uom_code;
			$stockDetail->stock_transfer_number = $request->stock_transfer_number;
			$stockDetail->status = 'P';
			$stockDetail->device_code = $request->device_code;
			$stockDetail->updated_by  = auth()->user()->id;
			$stockDetail->updated_at  = new \DateTime();
			$stockDetail->modified_by = $request->salesman_code;
			$stockDetail->modified_date = new Carbon($request->transfer_date_from);
			$stockDetail->sfa_modified_date = new Carbon($request->transfer_date_from);
			$stockDetail->save();
		}
		
		return response()->json(['success'=>true]);
	}
	
	/**
	 * Save replenishment
	 * @param ReplenishmentRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveReplenishment(ReplenishmentRequest $request)
	{		
		DB::beginTransaction();
		
		$nextPkId = ModelFactory::getInstance('TxnReplenishmentHeader')->max('replenishment_header_id');
		if($nextPkId >= config('system.custom_pk_start'))
			$nextPkId++;
		else
			$nextPkId = config('system.custom_pk_start');
		
		if($request->id)
			$replenish = ModelFactory::getInstance('Replenishment')->find($request->id);
		else 
			$replenish = ModelFactory::getInstance('Replenishment');
		$replenish->fill($request->all());
		if($replenish->save())
		{
			$items = $request->get('item_code');
			$qty = $request->get('quantity');
			
			if($items && $qty)
			{
				$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');				
				if($request->id)
				{
					$replenishment = ModelFactory::getInstance('TxnReplenishmentHeader')->where('reference_number',$replenish->reference_num)->first();
					if(!$replenish)
					{
						DB::rollback();
						return response()->json(['success'=>false]);
					}
				}
				else 
				{
					$replenishment = ModelFactory::getInstance('TxnReplenishmentHeader');
					$replenishment->replenishment_header_id = $nextPkId;
				}				
				$replenishment->reference_number = $request->reference_num;
				$vans = $vanInventoryPresenter->getSalesmanVan($request->salesman_code);
				$replenishment->van_code = array_shift($vans);
				$replenishment->replenishment_date = new Carbon($request->replenishment_date_from);
				$replenishment->modified_by = $request->salesman_code;
				$replenishment->modified_date = new Carbon();
				$replenishment->sfa_modified_date = new \DateTime();
				$replenishment->status = 'A';
				$replenishment->updated_by  = auth()->user()->id;
				$replenishment->updated_at  = new \DateTime();
				
				if($replenishment->save())
				{
					ModelFactory::getInstance('TxnReplenishmentDetail')
								->where('reference_number',$replenishment->reference_number)
								->delete();
					
					foreach($items as $k=>$item)
					{
						
						$nextPkId = ModelFactory::getInstance('TxnReplenishmentDetail')->max('replenishment_detail_id');
						if($nextPkId >= config('system.custom_pk_start'))
							$nextPkId++;
						else
							$nextPkId = config('system.custom_pk_start');
												
						$detail = ModelFactory::getInstance('TxnReplenishmentDetail');
						$detail->replenishment_detail_id = $nextPkId;
						$detail->reference_number = $replenishment->reference_number;			
						$detail->item_code = $item;
						$detail->quantity = isset($qty[$k]) ? $qty[$k] : 0;
						$detail->uom_code = 'PCS';			
						$detail->status = 'A';			
						$detail->updated_by  = auth()->user()->id;
						$detail->updated_at  = new \DateTime();
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
				ModelFactory::getInstance('TxnReplenishmentHeader')
							->where('reference_number',$replenish->reference_num)
							->delete();
				
				ModelFactory::getInstance('TxnReplenishmentDetail')
							->where('reference_number',$replenish->reference_num)
							->delete();
			}
		}
		
		return response()->json(['success'=>true]);
	}
}
