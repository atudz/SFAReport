<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StockTransferRequest extends Request
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
            'stock_transfer_number' => 'required',
        	'transfer_date_from' => 'required',
        	'src_van_code' => 'required',
        	'dest_van_code' => 'required',        	
        	'item_code' => 'required',
        	//'device_code' => 'required',
        	'salesman_code' => 'required',
        	'uom_code' => 'required',
        	'salesman_code' => 'required',
        	'quantity' => 'required|integer|min:0',
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
    			'transfer_date_from' => 'transaction date',
    			'src_van_code' => 'source van code',
    			'item_code' => 'item',
    			'salesman_code' => 'salesman',
    			'uom_code' => 'uom',
    	];
    }
}
