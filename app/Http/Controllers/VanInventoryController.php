<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Requests\StockTransferRequest;
use App\Factories\ModelFactory;
use Carbon\Carbon;

class VanInventoryController extends ControllerCore
{

	/**
	 * Save stock transfer data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function saveStockTransfer(StockTransferRequest $request)
	{
		$stockTransfer = ModelFactory::getInstance('TxnStockTransferInHeader');
		$stockTransfer->stock_transfer_in_header_id = 2000000000;
		$stockTransfer->stock_transfer_number = $request->stock_transfer_number;
		$stockTransfer->salesman_code = $request->salesman_code;
		$stockTransfer->dest_van_code = $request->dest_van_code;
		$stockTransfer->src_van_code = $request->src_van_code;
		$stockTransfer->modified_by = $request->salesman_code;
		$stockTransfer->modified_date = new Carbon($request->transfer_date_from);
		$stockTransfer->sfa_modified_date = new \DateTime();
		$stockTransfer->status = 'P';
		$stockTransfer->device_code = $request->device_code;
		$stockTransfer->updated_by  = auth()->user()->id;
		$stockTransfer->updated_at  = new \DateTime();
		$stockTransfer->transfer_date = new Carbon($request->transfer_date_from);
		
		if($stockTransfer->save())
		{
			$stockDetail = ModelFactory::getInstance('TxnStockTransferInDetail');
			$stockDetail->stock_transfer_in_detail_id = 2000000000;
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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
