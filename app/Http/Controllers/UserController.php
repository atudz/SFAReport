<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;

class UserController extends ControllerCore
{


    public function changePassword(){

    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function save(Request $request)
    {
    	$id = (int)$request->get('id');
        $user = ModelFactory::getInstance('User')->findOrNew($id);
        $user->firstname = $request->get('fname');
        $user->lastname = $request->get('lname');
        $user->middlename = $request->get('mname');
        if($request->get('password'))
        	$user->password = bcrypt($request->get('password'));
        $user->email = $request->get('email');
        if($request->get('username'))
        	$user->username = $request->get('username');
        $user->address1 = $request->get('address');
     	$user->created_by = auth()->user()->id;
     	$user->gender = $request->get('gender');
     	$user->age = $request->get('age');
        $user->user_group_id = $request->get('role');
        
        $user->location_assignment_code = $request->get('area');
        $user->location_assignment_type = $request->get('assignment_type');
        $user->location_assignment_from = $request->get('assignment_date_from');
        $user->location_assignment_to = $request->get('assignment_date_to');
        
        $user->telephone = $request->get('telephone');
       	$user->mobile = $request->get('mobile');
       	$user->save();
        $response['success'] = true;
        $response['id'] = $user->id;
        
        
        return response()->json($response);
    }

    /**
     * Activate user
     *
     * @return Response
     */
    public function activate($id)
    {
    	$user = ModelFactory::getInstance('User')->find($id);
    	$user->status = 'A';
    	$user->save();
    	
    	$response['success'] = true;
    	return response()->json($response);
    }
    
    /**
     * Dectivate user
     *
     * @return Response
     */
    public function deactivate($id)
    {
    	$user = ModelFactory::getInstance('User')->find($id);
    	$user->status = 'I';
    	$user->save();
    	
    	$response['success'] = true;
    	return response()->json($response);
    }
    
    /**
     * Dectivate user
     *
     * @return Response
     */
    public function delete($id)
    {
    	$user = ModelFactory::getInstance('User')->find($id);
    	if($user)
    	{
    		$user->status = 'D';
    		$user->save();
    		$user->delete();    		
    	}
    	    	
    	$response['success'] = true;
    	return response()->json($response);
    }
}
