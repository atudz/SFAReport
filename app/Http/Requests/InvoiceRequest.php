<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InvoiceRequest extends Request
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
        	'invoice_start' => 'required|alpha_num|valid_invoice',
        	'invoice_end' => 'required|alpha_num|valid_invoice',
        	'status' => 'required',
        ];
    }
    
    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function messages()
    {
    	return [
    			'valid_invoice' => 'Invoice number must contain numeric characters',
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
    	];
    }
}
