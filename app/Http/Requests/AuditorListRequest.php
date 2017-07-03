<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AuditorListRequest extends Request
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
            'auditor_id'    => 'required|exists:user,id',
            'salesman_code' => 'required|exists:app_salesman,salesman_code',
            'area_code'     => 'required|exists:app_area,area_code',
            'type'          => 'required',
            'period_from'   => 'required|date',
            'period_to'     => 'required|date',
        ];
    }
}