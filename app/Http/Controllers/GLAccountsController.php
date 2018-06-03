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
        try{
            $gl_accounts = ModelFactory::getInstance('GLAccount')->get();

            return  response()->json([
                        'success' => true,
                        'data'    => $gl_accounts
                    ]);
        } catch (Exception $e) {
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
        try{
            $gl_account = ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->first();

            return  response()->json([
                        'success'=> true,
                        'data'   => $gl_account
                    ]); 
        } catch (Exception $e) {
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
        try {
            ModelFactory::getInstance('GLAccount')->create($request->only(['code','description'])
            );
            return response()->json(['success'=> true]);
        } catch (Exception $e) {
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
        try {
            ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->update($request->only(['code','description'])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
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
        try {
            if(ModelFactory::getInstance('GLAccount')->where('id','=',$gl_account_id)->delete()){
                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}