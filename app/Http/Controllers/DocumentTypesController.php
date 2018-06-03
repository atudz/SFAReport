<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\DocumentTypeRequest;

class DocumentTypesController extends ControllerCore
{
    /**
     * Gets all Document Types
     * @return json
     */
    public function index()
    {
        try{
            $document_types = ModelFactory::getInstance('DocumentType')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $document_types
                    ]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Get a certain Document Type
     * @param  [integer] $document_type_id
     * @return json
     */
    public function show($document_type_id)
    {
        try{
            $document_type = ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->first();

            return  response()->json([
                        'success'=> true,
                        'data'   => $document_type
                    ]); 
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create an Document Types
     * @param  DocumentTypeRequest $request
     * @return json
     */
    public function store(DocumentTypeRequest $request)
    {
        try {
            ModelFactory::getInstance('DocumentType')->create($request->only(['type','description'])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update an Document Types
     * @param  DocumentTypeRequest $request
     * @param  [integer] $document_type_id
     * @return json
     */
    public function update(DocumentTypeRequest $request,$document_type_id)
    {
        try {
            ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->update($request->only(['type','description'])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete an Document Types
     * @param  [integer] $document_type_id
     * @return json
     */
    public function destroy($document_type_id)
    {
        try {
            if(ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->delete()){
                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}