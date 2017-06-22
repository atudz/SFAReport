<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Requests\StockTransferRequest;
use App\Factories\ModelFactory;
use Carbon\Carbon;
use App\Http\Requests\ActualCount;
use App\Factories\PresenterFactory;
use DB;
use App\Http\Models\Replenishment;
use App\Http\Requests\AdjustmentRequest;
use App\Http\Requests\AdjustmentDelete;
use App\Http\Requests\ActualCountRequest;
use App\Http\Requests\ActualCountDelete;
use Illuminate\Http\Request;

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
				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
                	'action_identifier' => '',
				    'action'            => 'updating Van Inventory - Stock Transfer Header id' . $request->stock_transfer_id
				]);
				//dd($stockTransfer->stock_transfer_number);
				$this->addStockTranserItem($request, $stockTransfer->stock_transfer_number);

				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
                	'action_identifier' => 'updating',
				    'action'            => 'done updating Van Inventory - Stock Transfer Header id' . $request->stock_transfer_id
				]);
			}
		}
		else
		{
			ModelFactory::getInstance('UserActivityLog')->create([
				'user_id'           => auth()->user()->id,
			    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
                'action_identifier' => '',
			    'action'            => 'creating Van Inventory - Stock Transfer Header'
			]);

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

				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
                	'action_identifier' => 'creating',
				    'action'            => 'done creating Van Inventory - Stock Transfer Header id ' . $stockTransfer->stock_transfer_in_header_id
				]);
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
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
            'action_identifier' => '',
		    'action'            => 'creating Van Inventory - Stock Transfer Detail'
		]);

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

		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','stock-transfer')->value('id'),
            'action_identifier' => 'creating',
		    'action'            => 'done creating Van Inventory - Stock Transfer Detail id ' . $stockTransfer->stock_transfer_in_detail_id
		]);

		return $stockDetail->save();
	}
	
	/**
	 * Save replenishment
	 * @param ActualCount $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveActualCount(ActualCountRequest $request)
	{		
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
            'action_identifier' => '',
		    'action'            => 'creating Van Inventory - Actual Count Replenishment'
		]);

		DB::beginTransaction();
		
		$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
		
		$vans = $vanInventoryPresenter->getSalesmanVan($request->salesman_code);
		$replenish = ModelFactory::getInstance('Replenishment')->findOrNew((int)$request->id);		
		$replenish->van_code = $vans ? array_shift($vans) : '';
		if(is_null($replenish->van_code))
			$replenish->van_code = '';
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
					
				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
            		'action_identifier' => '',
				    'action'            => 'deleting Van Inventory - Actual Count Replenishment Item having reference_number' . $replenish->reference_number
				]);

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
						ModelFactory::getInstance('UserActivityLog')->create([
							'user_id'           => auth()->user()->id,
						    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
                			'action_identifier' => '',
						    'action'            => 'error creating Van Inventory - Actual Count Replenishment Item'
						]);

						DB::rollback();
						return response()->json(['success'=>false]);						
					}

					ModelFactory::getInstance('UserActivityLog')->create([
						'user_id'           => auth()->user()->id,
					    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
            			'action_identifier' => '',
					    'action'            => 'done creating Van Inventory - Actual Count Replenishment Item having id' . $detail->id
					]);
				}
			}

			ModelFactory::getInstance('UserActivityLog')->create([
				'user_id'           => auth()->user()->id,
			    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
                'action_identifier' => 'creating',
			    'action'            => 'done creating Van Inventory - Actual Count Replenishment id' . $replenish->id
			]);
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
	public function deleteActualCount(ActualCountDelete $request, $id)
	{
		
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
            'action_identifier' => '',
		    'action'            => 'deleting Van Inventory - Actual Count Replenishment id' . $id
		]);

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

				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
                	'action_identifier' => '',
				    'action'            => 'deleting Van Inventory - Actual Count Replenishment Item having reference_number' . $replenish->reference_number
				]);

				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','actual-count-replenishment')->value('id'),
            		'action_identifier' => 'deleting',
				    'action'            => 'done deleting Van Inventory - Actual Count Replenishment id' . $id
				]);
			}
		}
		
		return response()->json(['success'=>true]);
	}
	
	
	/**
	 * Save replenishment adjustment
	 * @param ActualCount $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveAdjustment(AdjustmentRequest $request)
	{
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
            'action_identifier' => '',
		    'action'            => 'creating Van Inventory - Adjustment Replenishment'
		]);

		DB::beginTransaction();
	
		$vanInventoryPresenter = PresenterFactory::getInstance('VanInventory');
	
		$vans = $vanInventoryPresenter->getSalesmanVan($request->salesman_code);
		$replenish = ModelFactory::getInstance('Replenishment')->findOrNew((int)$request->id);
		$replenish->van_code = $vans ? array_shift($vans) : '';
		if(is_null($replenish->van_code))
			$replenish->van_code = '';
		$replenish->replenishment_date = new Carbon($request->replenishment_date_from);
		$replenish->adjustment_reason = $request->adjustment_reason;
	
		$today = new Carbon();
		$replenish->modified_date = $today;
		$replenish->sfa_modified_date = $today;
		$replenish->modified_by = $request->salesman_code;
		$replenish->type = Replenishment::ADJUSTMENT_TYPE;
	
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
					
				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
            		'action_identifier' => '',
				    'action'            => 'deleting Van Inventory - Adjustment Replenishment Item having reference_number' . $replenish->reference_number
				]);

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
						ModelFactory::getInstance('UserActivityLog')->create([
							'user_id'           => auth()->user()->id,
						    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
                			'action_identifier' => '',
						    'action'            => 'error creating Van Inventory - Adjustment Replenishment Item'
						]);

						DB::rollback();
						return response()->json(['success'=>false]);
					}

					ModelFactory::getInstance('UserActivityLog')->create([
						'user_id'           => auth()->user()->id,
					    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
                		'action_identifier' => '',
					    'action'            => 'creating Van Inventory - Adjustment Replenishment Item having id' . $detail->id
					]);
				}
			}

			ModelFactory::getInstance('UserActivityLog')->create([
				'user_id'           => auth()->user()->id,
			    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
                'action_identifier' => 'creating',
			    'action'            => 'done creating Van Inventory - Adjustment Replenishment id' . $replenish->id
			]);
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
	
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'           => auth()->user()->id,
		    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
            'action_identifier' => '',
		    'action'            => 'deleting Van Inventory - Adjustment Replenishment id' . $id
		]);

		$replenish = ModelFactory::getInstance('Replenishment')->find($id);
		if($replenish)
		{
			$replenish->remarks = $request->remarks;
			$replenish->save();
				
			if($replenish->delete())
			{
				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
                	'action_identifier' => '',
				    'action'            => 'deleting Van Inventory - Adjustment Replenishment Item having reference_number' . $replenish->reference_number
				]);

				ModelFactory::getInstance('ReplenishmentItem')
				->where('reference_number',$replenish->reference_number)
				->delete();

				ModelFactory::getInstance('UserActivityLog')->create([
					'user_id'           => auth()->user()->id,
				    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','adjustment-replenishment')->value('id'),
                	'action_identifier' => 'deleting',
				    'action'            => 'done deleting Van Inventory - Adjustment Replenishment id' . $id
				]);
			}
		}
	
		return response()->json(['success'=>true]);
	}
	
	/**
	 * Post Replenishment data
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postReplenishment(Request $request)
	{
		$headers = (array)$request->session()->get('replenishments');
		$headerRefs = [];
		foreach($headers as $header)
		{
			$headerRefs[] = $header['reference_number'];
			$replenishment = ModelFactory::getInstance('TxnReplenishmentHeader');
			$replenishment->replenishment_header_id = replenishment_next_pk();
			$replenishment->reference_number = $header['reference_number'];
			$replenishment->van_code = $header['van_code'];
			$replenishment->replenishment_date = new Carbon($header['replenishment_date']);
			$replenishment->modified_by = 'STAGING';
			$replenishment->modified_date = new Carbon();
			$replenishment->sfa_modified_date = new Carbon();
			$replenishment->version = '';
			$replenishment->status = 'A';
			$replenishment->updated_by = auth()->user()->id;
			$replenishment->updated_at = new Carbon();
			$replenishment->save();											
		}
		
		if($headerRefs){
			$data = ['posted_date'=> new Carbon(), 'posted_by'=>auth()->user()->id];
			ModelFactory::getInstance('Replenishment')->whereIn('reference_number',$headerRefs)->update($data);			
		}
		
		$details = (array)$request->session()->get('replenishment_details');
		$detailRefs = [];
		foreach($details as $detail)
		{
			$detailRefs[]  = $detail['reference_number'];
			$item = ModelFactory::getInstance('TxnReplenishmentDetail');
			$item->replenishment_detail_id = replenishment_next_pk(true);
			$item->reference_number = $detail['reference_number'];
			$item->item_code = $detail['item_code'];
			$item->uom_code = $detail['uom_code'];
			$item->quantity = $detail['quantity'];
			$item->modified_by = 'STAGING';
			$item->modified_date = new Carbon();
			$item->sfa_modified_date = new Carbon();
			$item->version = '';
			$item->status = 'A';
			$item->updated_by = auth()->user()->id;
			$item->updated_at = new Carbon();
			$item->save();			
		}
		
		if($detailRefs){
			$data = ['posted_date'=> new Carbon(), 'posted_by'=>auth()->user()->id];
			ModelFactory::getInstance('Replenishment')->whereIn('reference_number',$detailRefs)->update($data);
		}
				
		$request->session()->forget(['replenishment_details','replenishments']);
		
		if(!count($details) && !count($headers)){
			return response()->json(['success'=>false,'msg'=>'No records to post']);
		}
		
		return response()->json(['success'=>true]);
	}
	
	/**
	 * Seed Header
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function seedHeader(Request $request)
	{
		$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedReplenishment(true);
			
		$replenishments = [];	
		$data = $prepare->get();
		
		if(count($data) < 1){
			return response()->json(['success'=>false,'msg'=>'No records to seed']);
		}
		
		$previous  = $request->session()->get('replenishments');
		$refs = collect($previous)->pluck('reference_number')->toArray();
		
		foreach($data as $replenish)
		{
			if(!in_array($replenish->reference_number, $refs)){
				$row = (array)$replenish;
				unset($row['type']);
				$replenishments[] = $row;
			}			
		}
		
		$replenishments = array_merge((array)$previous,$replenishments);		
		$request->session()->set('replenishments', $replenishments);
		
		return response()->json(['success'=>$replenishments]);
	}
	
	/**
	 * Seed Header
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function seedDetail(Request $request)
	{
		$prepare = PresenterFactory::getInstance('VanInventory')->getPreparedReplenishment(true);
			
		$data = $prepare->get();
		
		if(count($data) < 1){
			return response()->json(['success'=>false,'msg'=>'No records to seed']);
		}
		
		$previous  = $request->session()->get('replenishment_details');
		$prevRefs = collect($previous)->pluck('reference_number')->toArray();
		$refs = [];
		foreach($data as $replenish)
		{
			if(!in_array($replenish->reference_number, $prevRefs)){
				$refs[] = $replenish->reference_number;
			}
		}
		
		$items = ModelFactory::getInstance('ReplenishmentItem')
						->whereIn('reference_number',$refs)
						->get(['reference_number','item_code','uom_code','quantity']);
		
		$details = array_merge((array)$previous,$items->toArray());						
		
		$request->session()->set('replenishment_details', $details);
		
		return response()->json(['success'=>$details]);
	}
	
	/**
	 * Seed Clear
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function seedClear(Request $request)
	{
		$request->session()->forget(['replenishment_details','replenishments']);
		return response()->json(['success'=>true]);
	}
}
