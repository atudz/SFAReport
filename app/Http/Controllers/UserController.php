<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;

class UserController extends ControllerCore
{

	/**
	 * Change password
	 */
    public function changePassword(Request $request) 
    {
		
    	$data['success'] = false;
    	$data['failure'] = true;
    	
    	if($request->get('old_pass') && $request->get('new_pass'))
    	{
    		$user = auth()->user();
    		$password = $user->password;
    		if(\Hash::check($request->get('old_pass'),$password))
    		{
    			$user->password = bcrypt($request->get('new_pass'));
    			$user->save();
    			
    			$data['success'] = true;
    			$data['failure'] = false;
    		}
    	}
    	
    	return response()->json($data);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function save(Request $request)
    {
        $sanitizeFields = ['firstname', 'lastname', 'middlename', 'username', 'address1', 'telephone', 'mobile'];

        $roleAdmin = ModelFactory::getInstance('UserGroup')->admin()->first()->id; 
        if($request->get('role') == $roleAdmin)
        {
        	$max = config('system.max_admin_users');
        	$adminCount = ModelFactory::getInstance('User')->where('user_group_id',$roleAdmin)->count();
        	if($adminCount >= $max)
        	{
        		// Minus 1 to exclude default admin user
        		$response['error'] = 'Maximum of '.($max-1).' Administrators only.';        		
        		return response()->json($response);
        	}
        }
        
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
        if($request->get('assignment_date_from'))
        	$user->location_assignment_from = new \DateTime($request->get('assignment_date_from'));
        if($request->get('assignment_date_to'))
        	$user->location_assignment_to = new \DateTime($request->get('assignment_date_to'));
        
        $user->telephone = $request->get('telephone');
       	$user->mobile = $request->get('mobile');

        foreach($sanitizeFields as $field)
        {
            if(isset($user->$field) && $user->$field)
            {
                $user->$field = $this->_sanitize($user->$field);
            }
        }

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

    private function _sanitize($value)
    {
        return trim($value);
    }
}
