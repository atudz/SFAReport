<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\InvoiceDelete;
use App\Factories\PresenterFactory;

class InvoiceController extends ControllerCore
{

	/**
	 * Validate Invoice
	 * @param unknown $start
	 * @param unknown $end
	 * @param unknown $id
	 */
	public function validateInvoice($start,$end, $id)
	{
		$messages = [];
		
		$prepare = ModelFactory::getInstance('Invoice')
					->where(function($query) use ($start,$end){
						$query->whereBetween('invoice_start',[$start,$end]);
						$query->OrWhereBetween('invoice_end',[$start,$end]);
					});
					
					
		if($id)
			$prepare->where('id','<>',$id);
		
		if($prepare->exists())
		{
			$messages = [
				'invoice_start' => ['Invoice number has been taken already'],
				'invoice_end' => ['Invoice number has been taken already'],
			];
		}
		
		if(!$messages)
		{		
			if(0 < strcmp($start, $end) )
			{
				$messages = [
						'invoice_start' => ['Start must be less than end series'],						
				];
			}
		}
					
		return $messages;
	}
	
    /**
     * Update/Save the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function save(InvoiceRequest $request)
    {
    	$id = (int)$request->id;
    	
//     	if($messages = $this->validateInvoice($request->invoice_start, $request->invoice_end, $request->id))
//     		return response()->json($messages,422);
    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => '',
            'action'            => (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Invoice Series Mapping ' . (!empty($id) || !is_null($id) ? 'id ' . $id : '')
        ]);

        $invoice = ModelFactory::getInstance('Invoice')->findOrNew($id);        
        $invoice->fill($request->all());
        
        $invoice->invoice_start = str_pad((int)$invoice->invoice_start,7,'0',STR_PAD_LEFT);
        $invoice->invoice_end = str_pad((int)$invoice->invoice_end,7,'0',STR_PAD_LEFT);
        
        $reportPresenter = PresenterFactory::getInstance('Reports');
        $areas = $reportPresenter->getSalesmanArea($request->salesman_code);
        $invoice->area_code = $areas ? array_shift($areas) : '';
        if(!$invoice->save()){
        	ModelFactory::getInstance('UserActivityLog')->create([
	            'user_id'           => auth()->user()->id,
	            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
                'action_identifier' => '',
	            'action'            => 'error ' . (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Invoice Series Mapping ' . (!empty($id) || !is_null($id) ? 'id ' . $id : '')
	        ]);

        	return response()->json(['success'=>false,'msg'=>'Server error']);
    	}

    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => (!empty($id) || !is_null($id) ? 'updating' : 'creating'),
            'action'            => 'done ' . (!empty($id) || !is_null($id) ? 'updating' : 'creating') . ' Invoice Series Mapping id ' . (!empty($id) || !is_null($id) ? $id : $invoice->id) 
        ]);

        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(InvoiceDelete $request, $id)
    {	
    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting Invoice Series Mapping id ' . $id
        ]);

        $invoice = ModelFactory::getInstance('Invoice')->find($id);
        $invoice->remarks = $request->remarks;
        $invoice->save();

    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => '',
            'action'            => 'saving remarks for deleting Invoice Series Mapping id ' . $id
        ]);

        if(!$invoice->save()){
	    	ModelFactory::getInstance('UserActivityLog')->create([
	            'user_id'           => auth()->user()->id,
	            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
                'action_identifier' => '',
	            'action'            => 'error saving remarks for deleting Invoice Series Mapping id ' . $id
	        ]);

        	return response()->json(['success'=>false,'msg'=>'Server error']);
        }
        if(!$invoice->delete()){
	    	ModelFactory::getInstance('UserActivityLog')->create([
	            'user_id'           => auth()->user()->id,
	            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
                'action_identifier' => '',
	            'action'            => 'error deleting Invoice Series Mapping id ' . $id
	        ]);

        	return response()->json(['success'=>false,'msg'=>'Server error']);
        }

    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => '',
            'action'            => 'done saving remarks for deleting Invoice Series Mapping id ' . $id
        ]);

    	ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','invoice-series-mapping')->value('id'),
            'action_identifier' => 'deleting',
            'action'            => 'done deleting Invoice Series Mapping id ' . $id
        ]);
        
        return response()->json(['success'=>true]);
    }
}
