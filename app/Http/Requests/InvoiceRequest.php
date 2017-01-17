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
        	'invoice_start' => 'required|numeric|positive|available',
        	'invoice_end' => 'required|numeric|positive|available',
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
    			'numeric' => 'Invoice number must be numeric characters',
    			'positive' => 'Invoice number must not be negative',
    			'available' => 'Invoice number has been taken already',
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
