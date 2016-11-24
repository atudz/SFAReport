<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdjustmentRequest extends Request
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
	        'replenishment_date_from' => 'required',
	        'reference_number' => $this->get('id') ? 'required' : 'required|unique:replenishment',
	        'adjustment_reason' => 'required',
	        'item_code' => 'array',
	        'quantity' => 'array',
        	'brands' => 'array',
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
    			'replenishment_date_from' => 'Adjustment date/time ',
    			'reference_num' => 'Adjustment No.',
    	];
    }
}
