<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $userGroupModel = ModelFactory::getInstance('UserGroup');

        $roleAdmin = $userGroupModel->admin()->first()->id; 
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
		
		if ($request->get('assignment_date_from') > $request->get('assignment_date_to')) {

			$response['exists'] = true;
			$response['error'] = 'Invalid date range.';

			return response()->json($response);
		}

        if($request->get('age') && 18 > $request->get('age'))
        {
            $response['exists'] = true;
            $response['error'] = 'User cannot be below 18.';
            return response()->json($response);
        }

        $userModel = ModelFactory::getInstance('User');

        $id = (int)$request->get('id');
		if ($request->has('jr_salesman_code')) {
			$exist = $userModel->where('salesman_code', $request->get('jr_salesman_code'))->where('id', '<>', $id)->exists();
			if ($exist) {
				$response['exists'] = true;
				$code = $userModel->where('salesman_code', 'like',
					$request->get('salesman_code') . '-%')->orderBy('salesman_code', 'desc')->first();
				$response['error'] = 'Jr. Salesman code already exists available code is ' .
					$this->generateJrSalesCode($code, $request->get('salesman_code')) .'.';

				return response()->json($response);
			}
		}

        $exist = $userModel->where('salesman_code',$request->get('salesman_code'))->where('id','<>',$id)->exists();
		if ($request->get('salesman_code') && $exist) {
			$response['exists'] = true;
			$response['error'] = 'Salesman code already exists.';

			return response()->json($response);
		}
        
        $user = $userModel
        			->where(function($query) use($request) {
        					$query->where('email',$request->get('email'));
        					$query->orWhere('username',$request->get('username'));
        				}	
        			)
        			->where('id','<>',$id)
        			->exists();        			
        if($user)
        {
        	$response['exists'] = true;
        	$response['error'] = 'User already exists.';
        	return response()->json($response);        	
        }

        $user = $userModel->findOrNew($id);
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
		$user->salesman_code = $request->has('jr_salesman_code') ? $request->get('jr_salesman_code') : $request->get('salesman_code');
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
    		$deletedEmail = $user->email.'.deleted';
    		$count = ModelFactory::getInstance('User')
    						->onlyTrashed()
    						->where('email','like',$deletedEmail.'%')
    						->count();
    		$user->email = !$count ? $deletedEmail : $deletedEmail.($count+1);
    		
    		$deletedUsername = $user->username.'.deleted';
    		$count = ModelFactory::getInstance('User')
			    		->onlyTrashed()
			    		->where('username','like',$deletedUsername.'%')
			    		->count();
    		if($user->name)
    			$user->username = !$count ? $deletedUsername : $deletedUsername.($count+1);
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

	public function generateJrSalesCode($code, $salesman_code)
	{
		if (!$code) {
			return $salesman_code . "-001";
		}
		return $salesman_code . "-" . str_pad(((int) (explode("-", $code->salesman_code)[1]) + 1), 3, "00", STR_PAD_LEFT);
	}

	public function userContactUs()
	{
		$data = [];
		Mail::queue('emails.contact_us', $data, function ($message) {
			$message->from('testmailgun101@gmail.com', 'sample email');
			$message->to('markgerald.nst@gmail.com');
			$message->subject('Account Activation');
		});

	}
}
