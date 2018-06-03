<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SegmentCodeRequest extends Request
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
                'segment_code' => 'required|unique:segment_codes,segment_code',
                'description'  => 'required',
                'abbreviation' => 'required'
            ];

            $segment_code_id = (request()->get('segment_code_id') != null) ? request()->get('segment_code_id') : $this->route('segment_code_id');

            if (!empty($segment_code_id) || !is_null($segment_code_id)) {
                $rules['segment_code'] = $rules['segment_code'] . ',' . $segment_code_id;
            }
        }

        return $rules;
    }
}