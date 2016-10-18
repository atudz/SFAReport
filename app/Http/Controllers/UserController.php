<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Factories\PresenterFactory;
use App\Http\Models\ContactUs;
use Carbon\Carbon;
use Exception;
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
        if($request->has('age') && 17 >= $request->get('age'))
        {
            $response['exists'] = true;
            $response['error'] = 'User age cannot be below 18.';
            return response()->json($response);
        }

        $userModel = ModelFactory::getInstance('User');

        $id = (int)$request->get('id');
		if ($request->has('jr_salesman_code')) {
			$exist = $userModel->where('salesman_code', $request->get('jr_salesman_code'))->where('id', '<>', $id)->exists();
			if ($exist) {
				$response['exists'] = true;
				$response['error'] = 'Jr. Salesman code already exists available code is ' .
					$this->generateJrSalesCode($request->get('salesman_code')) .'.';

				return response()->json($response);
			}
		}
		$appSalesmanModel = ModelFactory::getInstance('AppSalesman');
		//this will query a raw value to app salesman model.
		$appSalesmanRaw = $appSalesmanModel->where('salesman_code', $request->get('salesman_code'));
		//this will check if the salesman code exists in app salesman.
		$salesmanCodeExists = $appSalesmanRaw->exists();
		if ((($request->has('jr_salesman_code') || $request->get('salesman_code')) && !$salesmanCodeExists)) {
			$response['exists'] = true;
			$response['error'] = 'Salesman code does not exists in master list.';

			return response()->json($response);
		}

		$salesman_name = strtoupper($request->get('lname') . ", " . $request->get('fname'));
		$appSalesmanModel = ModelFactory::getInstance('AppSalesmanCustomer');
		$appSalesmanRaw = $appSalesmanModel->where('salesman_code', $request->get('salesman_code'))
			->where('status', 'A')
			->with(['salesmans' => function($query){
				$query->where('Status','A');
			}, 'customers' => function ($query) {
				$query->first();
			}])->first();

		//this will check if the salesman exists and matches the salesman name, branch and salesman_code in existing data in the database.
		$appSalesmanExists = ($appSalesmanRaw && ($appSalesmanRaw->salesmans && $appSalesmanRaw->salesmans[0]->salesman_name == $salesman_name) && ($appSalesmanRaw->customers && $appSalesmanRaw->customers[0]->area_code == $request->get('area'))) ?: false;
		$exist = $userModel->where('salesman_code', $request->get('salesman_code'))->where('id', '<>', $id)->exists();
		if ((!$request->has('jr_salesman_code') && $request->get('salesman_code')) && ($exist || !$appSalesmanExists)) {
			$response['exists'] = true;
			$response['error'] = 'Salesman code already exists.';

			return response()->json($response);
		}

		//this will check if the salesman code is inactive. this will be used for validation for jr salesman.
		if (($request->has('jr_salesman_code') && $request->get('salesman_code')) && !$appSalesmanExists) {
			$response['exists'] = true;
			$response['error'] = 'The salesman code that you\'ve entered is already been inactive.';

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
        	$response['error'] = 'Username already exist.';
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

	/**
	 * This will generate a jr salesman code.
	 * @param $salesman_code
	 * @return string
     */
	public function generateJrSalesCode($salesman_code)
	{
		$code = ModelFactory::getInstance('User')->where('salesman_code', 'like',
			$salesman_code . '-%')->orderBy('salesman_code', 'desc')->first();
		if (!$code) {
			return $salesman_code . "-001";
		}

		return $salesman_code . "-" . str_pad(((int)(explode("-", $code->salesman_code)[1]) + 1), 3, "00",
			STR_PAD_LEFT);
	}

	/**
	 * This will return a jr salesman code.
	 * @param $code
	 * @return mixed
	 */
	public function getJrSalesmanCode($code, $user_id = 0)
	{
		if ($user_id) {
			$salesman_code = ModelFactory::getInstance('User')->where('id', $user_id)->select('salesman_code')->first();
			$getCode = explode('-', $salesman_code->salesman_code);
			if ($code == $getCode[0]) {
				$data['result'] = $salesman_code->salesman_code;

				return response()->json($data);
			}
		}
		$data['result'] = $this->generateJrSalesCode($code);

		return response()->json($data);
	}

	/**
	 * This function will store the report for support page.
	 * @param Request $request
	 * @return mixed
     */
	public function userContactUs(Request $request)
	{
		$data = [
			'full_name'                => $request->get('name'),
			'mobile'                   => $request->get('mobile'),
			'telephone'                => $request->get('telephone'),
			'email'                    => $request->get('email'),
			'location_assignment_code' => $request->get('branch'),
			'time_from'                => Carbon::parse($request->get('callFrom'))->toTimeString(),
			'time_to'                  => Carbon::parse($request->get('callTo'))->toTimeString(),
			'subject'                  => $request->get('subject'),
			'message'                  => $request->get('message'),
			'status'                   => 'New'
		];
		$contactUs = ModelFactory::getInstance('ContactUs')->create($data);

		return response()->json($contactUs, 200);
	}

	/**
	 * This function will handle the sending of email.
	 * @param $support_id
	 */
	public function mail($support_id)
	{
		$contactUs = ModelFactory::getInstance('ContactUs')->with('file')->where('id', $support_id)->first();
		$branch = ModelFactory::getInstance('AppArea')->where('area_code',
			$contactUs->location_assignment_code)->select('area_name')->first();
		$data = [
			'reference_no'             => $contactUs->id,
			'full_name'                => $contactUs->full_name,
			'mobile'                   => $contactUs->mobile,
			'telephone'                => $contactUs->telephone,
			'email'                    => $contactUs->email,
			'location_assignment_code' => $branch->area_name,
			'time_from'                => date('h:i:s a', strtotime($contactUs->time_from)),
			'time_to'                  => date('h:i:s a', strtotime($contactUs->time_to)),
			'subject'                  => $contactUs->subject,
			'email_message'            => $contactUs->message
		];

		if ($contactUs->file) {
			$data['file_path'] = $contactUs->file->path;
			$data['file_name'] = $contactUs->file->filename;
		}

		Mail::send('emails.contact_us', $data, function ($message) use (&$data) {
			$message->from(config('system.from_email'), $data['subject']);
			$message->to(config('system.from'));
			if (!empty($data['file_path'])) {
				$message->attach($data['file_path'], ['as' => $data['file_name']]);
			}
			$message->subject($data['subject']);
		});

		//reply email to sender.
		$data['time_received'] = strftime("%b %d, %Y", strtotime($contactUs->created_at->format('m/d/Y')));
		$data['status'] = $contactUs->status;

		Mail::send('emails.auto_reply', $data, function ($message) use (&$data) {
			$message->from(config('system.from_email'), $data['subject']);
			$message->to($data['email']);
			$message->subject($data['subject']);
		});

		if (count(Mail::failures()) < 0) {
			return response()->json($contactUs, 200);
		} else {
			return response()->json('Email not sent.', 471);
		}
	}

	/**
	 * This will update the status or action from email event action.
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function userContactUsActionOrStatus(Request $request)
	{
		$contactUs = ModelFactory::getInstance('ContactUs')->find($request->get('id'));
		$request->get('type') == 'action' ? $contactUs->action = $request->get('action') : $contactUs->status = $request->get('action');
		$contactUs->save();

		return redirect('/#/summaryofincident.report');
	}

	/**
	 * This function will handle file uploads.
	 * @param $support_id
	 * @param Request $request
	 * @return mixed
	 */
	public function userContactUsFileUpload($support_id, Request $request)
	{
		try {
			$file = $request->all();
			//multiple by 1000 to convert the mb to kb.
			$fileSize = 1000 * PresenterFactory::getInstance('User')->getFileSize()->value;
			// divided by 1000 to convert the bytes to kb.
			$uploadedSize = ($file['file']->getSize() / 1000);

			if ($uploadedSize > $fileSize) {

				return response()->json('Max File size is 10mb.');
			}
			$directory = 'app' . DIRECTORY_SEPARATOR . 'support-page-files';
			mt_srand(time()); //seed the generator with the current timestamp
			$basename = md5(mt_rand());
			$filename = $basename . snake_case($file['file']->getClientOriginalName());

			$file['file']->move(storage_path($directory), $filename);
			$contactFile = ContactUs::find($support_id);
			$contactFile->file()->create([
				'path'     => storage_path($directory . DIRECTORY_SEPARATOR . $filename),
				'filename' => $file['file']->getClientOriginalName()
			]);

			return response()->json($contactFile);

		} catch (Exception $e) {
			return response()->json([
				'text' => $e->getMessage(),
				'code' => 500
			]);
		}

	}
}
