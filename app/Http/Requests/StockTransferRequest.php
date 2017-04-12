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
        $rules =  [
        	'stock_transfer_id' => 'required|exists:txn_stock_transfer_in_header,stock_transfer_in_header_id',
            'stock_transfer_number' => 'required|required|unique:txn_stock_transfer_in_header',
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
        
        if($this->get('type'))
        {        	
        	unset($rules['src_van_code'],$rules['transfer_date_from'],$rules['dest_van_code'],$rules['stock_transfer_number']);
        }
        else
        {
        	unset($rules['stock_transfer_id']);
        }
        
        
        return $rules;
    }
    
    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
    	return [
    			'stock_transfer_id' => 'Stock Transfer No.',
    			'transfer_date_from' => 'transaction date',
    			'src_van_code' => 'source van code',
    			'item_code' => 'item',
    			'salesman_code' => 'salesman',
    			'uom_code' => 'uom',
    	];
    }
}
