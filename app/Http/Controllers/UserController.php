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
        $user->password = bcrypt($request->get('password'));
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->address1 = $request->get('address');
     	$user->created_by = auth()->user()->id;
        $user->user_group_id = $request->get('role');
        
        $user->location_assignment_code = $request->get('area');
        $user->location_assignment_status = $request->get('status');
        $user->location_assignment_type = $request->get('assignment_type');
        $user->location_assignment_from = $request->get('assignment_date_from');
        $user->location_assignment_to = $request->get('assignment_date_to');
        
        $response['id'] = 0;        
        if($user->save())
        {
        	if($request->get('telephone'))
        	{
        		$phone = ModelFactory::getInstance('UserPhone');
        		$phone->phone_number = $request->get('telephone');
        		$phone->user_id = $user->id;
        		$phone->save();
        	}
        	if($request->get('mobile'))
        	{
        		$mobile = ModelFactory::getInstance('UserPhone');
        		$mobile->phone_number = $request->get('mobile');
        		$mobile->user_id = $user->id;
        		$mobile->save();
        	}        	
        	
        	
        	$response['success'] = true;
        	$response['id'] = $user->id;
        }
        else 
        {
        	$response['response'] = true;
        	$response['id'] = 0;
        }
        
        return response()->json($response);
    }

}
