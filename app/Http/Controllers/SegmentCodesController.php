<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\SegmentCodeRequest;

class SegmentCodesController extends ControllerCore
{
    /**
     * Gets all Segment Codes
     * @return json
     */
    public function index()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Segment Codes'
        ]);

        try{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Segment Codes'
            ]);

            $segment_codes = ModelFactory::getInstance('SegmentCode')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $segment_codes
                    ]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Segment Codes'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Get a certain Segment Code
     * @param  [integer] $segment_code_id
     * @return json
     */
    public function show($segment_code_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Segment Code id ' . $segment_code_id
        ]);

        try{
            $segment_code = ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->first();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Segment Code id ' . $segment_code_id
            ]);

            return  response()->json([
                        'success'=> true,
                        'data'   => $segment_code
                    ]); 
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Segment Code id ' . $segment_code_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create an Segment Codes
     * @param  SegmentCodeRequest $request
     * @return json
     */
    public function store(SegmentCodeRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating for Segment Codes'
        ]);

        try {
            ModelFactory::getInstance('SegmentCode')->create($request->only(['segment_code','description','abbreviation'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating for Segment Codes'
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating for Segment Codes'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update an Segment Codes
     * @param  SegmentCodeRequest $request
     * @param  [integer] $segment_code_id
     * @return json
     */
    public function update(SegmentCodeRequest $request,$segment_code_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating for Segment Codes id ' . $segment_code_id
        ]);

        try {
            ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->update($request->only(['segment_code','description','abbreviation'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating for Segment Codes id ' . $segment_code_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating for Segment Codes id ' . $segment_code_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete an Segment Codes
     * @param  [integer] $segment_code_id
     * @return json
     */
    public function destroy($segment_code_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting for Segment Codes id ' . $segment_code_id
        ]);

        try {
            if(ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->delete()){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                    'action_identifier' => 'deleting',
                    'action'            => 'done deleting for Segment Codes id ' . $segment_code_id
                ]);

                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting for Segment Codes id ' . $segment_code_id
            ]);

            return response()->json(['success'=> false]);
        }
    }
}