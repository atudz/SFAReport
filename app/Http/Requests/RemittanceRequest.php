<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Validator;

class RemittanceRequest extends Request
{

    public function __construct(){
        Validator::extend(
            'if_same_day_or_one_week_range', 
            function($attr, $value, $parameters) {
                $date_from = date('Y-m-d',strtotime($parameters[0]));
                $date_to = date('Y-m-d',strtotime($value));
                if(strtotime($date_from) == strtotime($date_to)){
                    return true;
                }

                $date_from_plus_seven = date('Y-m-d',strtotime('+7 days',strtotime($date_from)));
                if(strtotime($date_from_plus_seven) == strtotime($date_to)){
                    return true;
                }

                return false;
            },
            'The :attribute value must be same day or must be one week after date from'
        );
    }

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

        $rules = [
            'sr_salesman_code' => 'required|exists:app_salesman,salesman_code',
            'date_from'        => 'required|date',
            'date_to'          => 'required|date|if_same_day_or_one_week_range:' . (request()->get('date_from') != null ? request()->get('date_from') : $this->route('date_from')),
            'cash_amount'      =>  'required|integer',
            'check_amount'     =>  'required|integer'
        ];

        if(request()->get('jr_salesman_code') != null || $this->route('jr_salesman_code') != null)
        {
            $rules['jr_salesman_code'] = 'required|exists:rds_salesman,salesman_code';
        }

        return $rules;
    }
}