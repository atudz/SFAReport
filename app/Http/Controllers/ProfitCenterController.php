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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Profit Center'
        ]);

        try{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Profit Center'
            ]);

            $profit_centers = ModelFactory::getInstance('ProfitCenter')->with('area')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $profit_centers
                    ]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Profit Center'
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Profit Center id ' . $profit_center_id
        ]);

        try{
            $profit_center = ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->first();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Profit Center id ' . $profit_center_id
            ]);

            return  response()->json([
                        'success'=> true,
                        'data'   => $profit_center
                    ]); 
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Profit Center id ' . $profit_center_id
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating for Profit Center'
        ]);

        try {
            ModelFactory::getInstance('ProfitCenter')->create($request->only(['profit_center','area_code'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating for Profit Center'
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating for Profit Center'
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating for Profit Center id ' . $profit_center_id
        ]);

        try {
            ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->update($request->only(['profit_center','area_code'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating for Profit Center id ' . $profit_center_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating for Profit Center id ' . $profit_center_id
            ]);

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
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting for Profit Center id ' . $profit_center_id
        ]);

        try {
            if(ModelFactory::getInstance('ProfitCenter')->where('id','=',$profit_center_id)->delete()){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                    'action_identifier' => 'deleting',
                    'action'            => 'done deleting for Profit Center id ' . $profit_center_id
                ]);

                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting for Profit Center id ' . $profit_center_id
            ]);

            return response()->json(['success'=> false]);
        }
    }
}