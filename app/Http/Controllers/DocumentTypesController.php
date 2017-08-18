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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Document Types'
        ]);

        try{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Document Types'
            ]);

            $document_types = ModelFactory::getInstance('DocumentType')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $document_types
                    ]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Document Types'
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Document Types id ' . $document_type_id
        ]);

        try{
            $document_type = ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->first();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Document Types id ' . $document_type_id
            ]);

            return  response()->json([
                        'success'=> true,
                        'data'   => $document_type
                    ]); 
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Document Types id ' . $document_type_id
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating for Document Types'
        ]);

        try {
            ModelFactory::getInstance('DocumentType')->create($request->only(['type','description'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating for Document Types'
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating for Document Types'
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating for Document Types id ' . $document_type_id
        ]);

        try {
            ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->update($request->only(['type','description'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating for Document Types id ' . $document_type_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating for Document Types id ' . $document_type_id
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting for Document Types id ' . $document_type_id
        ]);

        try {
            if(ModelFactory::getInstance('DocumentType')->where('id','=',$document_type_id)->delete()){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                    'action_identifier' => 'deleting',
                    'action'            => 'done deleting for Document Types id ' . $document_type_id
                ]);

                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting for Document Types id ' . $document_type_id
            ]);

            return response()->json(['success'=> false]);
        }
    }
}