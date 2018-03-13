<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfitCenterRequest extends Request
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
        $rules = [];

        if ( Request::isMethod('post') || Request::isMethod('patch') ) {
            $rules = [
                'profit_center' => 'required|unique:profit_centers,profit_center',
                'area_code'     => 'required'
            ];

            $profit_center_id = (request()->get('profit_center_id') != null) ? request()->get('profit_center_id') : $this->route('profit_center_id');

            if (!empty($profit_center_id) || !is_null($profit_center_id)) {
                $rules['profit_center'] = $rules['profit_center'] . ',' . $profit_center_id;
            }
        }

        return $rules;
    }
}