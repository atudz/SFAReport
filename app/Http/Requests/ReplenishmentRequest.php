<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReplenishmentRequest extends Request
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
        	'reference_num' => 'required',
        	'counted' => 'required',
        	'confirmed' => 'required',
        	'last_sr' => 'required',
        	'last_rprr' => 'required',
        	'last_cs' => 'required',
        	'last_dr' => 'required',
        	'last_ddr' => 'required',
        	'item_code' => 'array',
        	'quantity' => 'array',
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
    		'replenishment_date' => 'Count date/time ',
    		'reference_num' => 'Count Sheet No.',
    	];
    }
}
