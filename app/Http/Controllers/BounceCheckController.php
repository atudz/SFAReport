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

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action_identifier' => '',
            'action'            => (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Bounce Check Report ' . (!empty($id) || !is_null($id) ? 'id ' . $id : '')
        ]);

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
        
        $payments = 0;        	
        if(!$id) {
            $payments = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$txnNumber.'%')->sum('payment_amount');
        }        
        $total1 = bcsub($bounceCheck->original_amount, $bounceCheck->payment_amount, 2);
        $bounceCheck->balance_amount = bcsub($total1, $payments, 2);
        
        $bounceCheck->created_by = auth()->user()->id;
        if(!$bounceCheck->save())
        {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error ' . (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Bounce Check Report ' . (!empty($id) || !is_null($id) ? 'id ' . $id : '')
            ]);

        	return response()->json(['success'=>0,'msg'=>'Server error']);
        }

        // Recompute payments
        $payments = ModelFactory::getInstance('BounceCheck')
                        ->where('txn_number','like',$txnNumber.'%')
                        ->get();
        $balance  = 0;
        $originalAmount = $bounceCheck->original_amount;
        foreach($payments as $payment) {
            if($balance == 0) {
                $balance = $payment->original_amount;
            }            
            $payment->original_amount = $originalAmount;
            $payment->balance_amount = bcsub($balance, $payment->payment_amount, 2);
            $payment->save();
            $balance = $payment->balance_amount;
        }
        
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action_identifier' => (!empty($id) || !is_null($id) ? 'updating' : 'creating'),
            'action'            => 'done ' . (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Bounce Check Report ' . (!empty($id) || !is_null($id) ? 'id ' . $id : $bounceCheck->id)
        ]);
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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting Bounce Check Report having txn_number ' . $txnNumber
        ]);

    	$bounceCheck = ModelFactory::getInstance('BounceCheck')->where('txn_number',$txnNumber)->first();
    	if(!$bounceCheck){
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'deleting error Bounce Check Report having txn_number ' . $txnNumber . ' - Transaction not found.'
            ]);
            return response()->json(['success'=>0,'msg'=>'Transaction not found.']);
        }
    	
    	DB::beginTransaction();
    	
    	$bounceCheck->delete_remarks = $request->comment;
    	$bounceCheck->save();

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'               => auth()->user()->id,
            'navigation_id'         => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
            'action_identifier'     => '',
            'action'                => 'saving remarks for deleting Bounce Check Report having txn_number ' . $txnNumber
        ]);
    	
    	if(!$bounceCheck->delete()){
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting Bounce Check Report having txn_number ' . $txnNumber
            ]);

            return response()->json(['success'=>0,'msg'=>'Server error.']);
        }

    	if(false !== strpos($txnNumber, '-'))
    	{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'Bounce Check Report having txn_number ' . $txnNumber .' has a "-"'
            ]);

    		$chunks = explode('-', $txnNumber);
    		$mainBounceCheck = ModelFactory::getInstance('BounceCheck')->where('txn_number',$chunks[0])->first();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'finding Bounce Check Report having txn_number ' . $txnNumber .' that has a "-"'
            ]);

    		if($mainBounceCheck)
    		{
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'found Bounce Check Report having txn_number ' . $txnNumber .' that has a "-"'
                ]);

    			$payments = ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$bounceCheck->txn_number.'%')->sum('payment_amount');
    			$total1 = bcsub($mainBounceCheck->original_amount, $mainBounceCheck->payment_amount, 2);
    			$mainBounceCheck->balance_amount = bcsub($total1, $payments, 2);
    			if(!$mainBounceCheck->save()){
                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                        'action_identifier' => '',
                        'action'            => 'error updating Bounce Check Report having txn_number ' . $txnNumber .' that has a "-"'
                    ]);

                    return response()->json(['success'=>0,'msg'=>'Server error.']);
                }
    		}
    	}
    	else
    	{
    		ModelFactory::getInstance('BounceCheck')->where('txn_number','like',$txnNumber.'%')->delete();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'done saving remarks for deleting Bounce Check Report having txn_number ' . $txnNumber
            ]);

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','bounce-check-report')->value('id'),
                'action_identifier' => 'deleting',
                'action'            => 'done deleting Bounce Check Report having txn_number ' . $txnNumber
            ]);
    	}
    	
    	DB::commit();
    	
    	return response()->json(['success'=>true]);    	
    }
}
