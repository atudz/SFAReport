<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DocumentTypeRequest extends Request
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
                'type'        => 'required|unique:document_types,type',
                'description' => 'required'
            ];

            $document_type_id = (request()->get('document_type_id') != null) ? request()->get('document_type_id') : $this->route('document_type_id');

            if (!empty($document_type_id) || !is_null($document_type_id)) {
                $rules['type'] = $rules['type'] . ',' . $document_type_id;
            }
        }

        return $rules;
    }
}