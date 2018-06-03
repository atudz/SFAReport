<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\ProfitCenterRequest;

class ProfitCenterController extends ControllerCore
{
    /**
     * Gets all Profit Center
     * @return json
     */
    public function index()
    {
        try{
            $profit_centers = ModelFactory::getInstance('ProfitCenter')->with('area')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $profit_centers
                    ]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Get a certain Profit Center
     * @param  [integer] $profit_center_id
     * @return json
     */
    public function show($profit_center_id)
    {
        try{
            $profit_center = ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->first();

            return  response()->json([
                        'success'=> true,
                        'data'   => $profit_center
                    ]); 
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create an Profit Center
     * @param  ProfitCenterRequest $request
     * @return json
     */
    public function store(ProfitCenterRequest $request)
    {
        try {
            ModelFactory::getInstance('ProfitCenter')->create($request->only(['profit_center','area_code'])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update an Profit Center
     * @param  ProfitCenterRequest $request
     * @param  [integer] $profit_center_id
     * @return json
     */
    public function update(ProfitCenterRequest $request,$profit_center_id)
    {
        try {
            ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->update($request->only(['profit_center','area_code'])
            );
            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete an Profit Center
     * @param  [integer] $profit_center_id
     * @return json
     */
    public function destroy($profit_center_id)
    {
        try {
            if(ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->delete()){
            	return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}