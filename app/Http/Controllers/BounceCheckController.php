<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Requests\BounceCheckRequest;
use App\Factories\ModelFactory;
use Carbon\Carbon;
use App\Http\Requests\BounceCheckDelete;
use DB;

class BounceCheckController extends ControllerCore
{

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function save(BounceCheckRequest $request)
    {
    	$id = (int)$request->id;
        $bounceCheck = ModelFactory::getInstance('BounceCheck')->findOrNew($id);
        $bounceCheck->fill($request->all());
        
        $bounceCheck->invoice_date = new Carbon($request->invoice_date_from);
        $bounceCheck->cheque_date = new Carbon($request->cheque_date_from);
        $bounceCheck->dm_date = new Carbon($request->dm_date_from);
        $bounceCheck->invoice_date = new Carbon($request->invoice_date_from);
        $bounceCheck->payment_date = new Carbon($request->payment_date_from);
        
        $bounceCheck->area_code = customer_area($request->customer_code,true);
        $bounceCheck->jr_salesman_id = sfa_jr_salesman($request->salesman_code,true);
        
        $txnNumber = $bounceCheck->txn_number;
        if(false !== strpos($txnNumber,'-'))
        	$txnNumber = explode('-', $txnNumber)[0];
        $payments = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$txnNumber.'%')->sum('payment_amount');
        $total1 = bcsub($bounceCheck->original_amount, $bounceCheck->payment_amount, 2);
        $bounceCheck->balance_amount = bcsub($total1, $payments, 2);
        
        if(!$bounceCheck->save())
        {
        	return response()->json(['success'=>0,'msg'=>'Server error']);
        }
        
        return response()->json(['success'=>1]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(BounceCheckDelete $request, $txnNumber)
    {
    	$bounceCheck = ModelFactory::getInstance('BounceCheck')->where('txn_number',$txnNumber)->first();
    	if(!$bounceCheck)
    		return response()->json(['success'=>0,'msg'=>'Transaction not found.']);
    	
    	
    	DB::beginTransaction();
    	
    	$bounceCheck->delete_remarks = $request->comment;
    	$bounceCheck->save();
    	
    	if(!$bounceCheck->delete())
    		return response()->json(['success'=>0,'msg'=>'Server error.']);
    	
    	if(false !== strpos($txnNumber, '-'))
    	{
    		$chunks = explode('-', $txnNumber);
    		$mainBounceCheck = ModelFactory::getInstance('BounceCheck')->where('txn_number',$chunks[0])->first();
    		if($mainBounceCheck)
    		{
    			$payments = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$bounceCheck->txn_number.'%')->sum('payment_amount');
    			$total1 = bcsub($mainBounceCheck->original_amount, $mainBounceCheck->payment_amount, 2);
    			$mainBounceCheck->balance_amount = bcsub($total1, $payments, 2);
    			if(!$mainBounceCheck->save())
    				return response()->json(['success'=>0,'msg'=>'Server error.']);
    		}
    	}
    	else
    	{
    		ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$txnNumber.'%')->delete();
    	}
    	
    	DB::commit();
    	
    	return response()->json(['success'=>true]);    	
    }
}
