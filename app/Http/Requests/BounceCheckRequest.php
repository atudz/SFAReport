<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BounceCheckRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        	'salesman_code' => 'required',
        	'customer_code' => 'required',
        	'dm_number' => 'required',
        	'dm_date_from' => 'required|date',
        	'invoice_number' => 'required',
        	'invoice_date_from' => 'required|date',
        	'bank_name' => 'required',
        	'cheque_date_from' => 'required|date',
        	'cheque_number' => 'required',
        	'original_amount' => 'required|numeric',
        	'payment_amount' => 'required|numeric',        	
        	'payment_date_from' => 'required|date',
        	'remarks' => 'required',        	
        	'txn_number' => 'required',
        	'reason' => 'required',
        	'id' => 'required|integer',
        ];
    }
    
    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
    	return [
    			'salesman_code' => 'Salesman',
    			'customer_code' => 'Customer',
    			'dm_date_from' => 'DM Date',
    			'invoice_date_from' => 'Invoice Date',
    			'cheque_date_from' => 'Check Date',
    			'payment_date_from' => 'Check Date',
    			'txn_number' => 'Transaction No.',
    			'cheque_number' => 'Check No.'
    	];
    }
}
