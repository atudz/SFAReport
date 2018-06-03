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
        try{
$segment_codes = ModelFactory::getInstance('SegmentCode')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $segment_codes
                    ]);
        } catch (Exception $e) {
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
        try{
            $segment_code = ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->first();

            return  response()->json([
                        'success'=> true,
                        'data'   => $segment_code
                    ]); 
        } catch (Exception $e) {
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
        try {
            ModelFactory::getInstance('SegmentCode')->create($request->only(['segment_code','description','abbreviation'])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
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
        try {
            ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->update($request->only(['segment_code','description','abbreviation'])
            );
            return response()->json(['success'=> true]);
        } catch (Exception $e) {
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
        try {
            if(ModelFactory::getInstance('SegmentCode')->where('id','=',$segment_code_id)->delete()){
                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}