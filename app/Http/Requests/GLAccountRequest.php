<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GLAccountRequest extends Request
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
                'code'        => 'required|unique:gl_accounts,code',
                'description' => 'required'
            ];

            $gl_account_id = (request()->get('gl_account_id') != null) ? request()->get('gl_account_id') : $this->route('gl_account_id');

            if (!empty($gl_account_id) || !is_null($gl_account_id)) {
                $rules['code'] = $rules['code'] . ',' . $gl_account_id;
            }
        }

        return $rules;
    }
}