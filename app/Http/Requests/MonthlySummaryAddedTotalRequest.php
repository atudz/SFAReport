<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MonthlySummaryAddedTotalRequest extends Request
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
        if(Request::isMethod('get')){
            return [];
        }

        return [
            'salesman_code'          => 'required|exists:app_salesman,salesman_code',
            'remarks'                => 'required',
            'summary_date'           => 'required',
            'total_collected_amount' => 'required|numeric',
            'sales_tax'              => 'required|numeric',
            'amount_for_commission'  => 'required|numeric'
        ];
    }
}