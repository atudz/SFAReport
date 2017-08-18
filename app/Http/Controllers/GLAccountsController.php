<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\GLAccountRequest;

class GLAccountsController extends ControllerCore
{
    /**
     * Gets all GL Accounts
     * @return json
     */
    public function index()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for GL Accounts'
        ]);

        try{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for GL Accounts'
            ]);

            $gl_accounts = ModelFactory::getInstance('GLAccount')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $gl_accounts
                    ]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for GL Accounts'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Get a certain GL Account
     * @param  [integer] $gl_account_id
     * @return json
     */
    public function show($gl_account_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for GL Account id ' . $gl_account_id
        ]);

        try{
            $gl_account = ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->first();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for GL Account id ' . $gl_account_id
            ]);

            return  response()->json([
                        'success'=> true,
                        'data'   => $gl_account
                    ]); 
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for GL Account id ' . $gl_account_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create an GL Accounts
     * @param  GLAccountRequest $request
     * @return json
     */
    public function store(GLAccountRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating for GL Accounts'
        ]);

        try {
            ModelFactory::getInstance('GLAccount')->create($request->only(['code','description'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating for GL Accounts'
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating for GL Accounts'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update an GL Accounts
     * @param  GLAccountRequest $request
     * @param  [integer] $gl_account_id
     * @return json
     */
    public function update(GLAccountRequest $request,$gl_account_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating for GL Accounts id ' . $gl_account_id
        ]);

        try {
            ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->update($request->only(['code','description'])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating for GL Accounts id ' . $gl_account_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating for GL Accounts id ' . $gl_account_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete an GL Accounts
     * @param  [integer] $gl_account_id
     * @return json
     */
    public function destroy($gl_account_id)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting for GL Accounts id ' . $gl_account_id
        ]);

        try {
            if(ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->delete()){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                    'action_identifier' => 'deleting',
                    'action'            => 'done deleting for GL Accounts id ' . $gl_account_id
                ]);

                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting for GL Accounts id ' . $gl_account_id
            ]);

            return response()->json(['success'=> false]);
        }
    }
}