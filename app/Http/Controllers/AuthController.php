<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use Illuminate\Http\Request;
use App\Factories\ModelFactory;


class AuthController extends ControllerCore
{
	/**
	 * Authenticate user
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function authenticate(Request $request)
	{
		$this->validate($request, [
				'login' => 'required|max:255', 'password' => 'required|max:255',
		]);

		$user = ModelFactory::getInstance('User')
					->where('email','=',$request->input('login'))
					->where('username','=',$request->input('login'),'or')
					->first();
		if($user && $user->status == 'I')
		{
			return redirect('/login')
			->withInput($request->only('login'))
			->withErrors([
					'error' => 'The user account is inactive. Try again?',
			]);
		}
		
		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	    $request->merge([$field => $request->input('login')]);
		
	    if (\Auth::attempt($request->only($field, 'password')))
	    {
	        return redirect('/');
	    }

	    return redirect('/login')
	    		->withInput($request->only('login'))
	    		->withErrors([
	        		'error' => 'The credentials you entered did not match our records. Try again?',
	    		]);
		
	}

	/**
	 * Reset user password
	 * @param Request $request
	 */
	public function resetPassword(Request $request)
	{
		$user = ModelFactory::getInstance('User')
					->where('email','=',$request->get('email'))
					->first();
		
		$this->validate($request, [
				'email' => 'required|max:255',
		]);

		if(!$user)
		{
			return redirect('/forgotpass')
						->withInput($request->only('email'))
						->withErrors([
								'error' => 'Invalid email.'
						]);
		}
		
		$newPass = str_random(10);
		$user->password = bcrypt($newPass);
		$user->save();

		$data = [
				'name' => ($user->fullname) ? $user->fullname : $user->id,
				'from' => config('system.from'),
				'password' => $newPass,
		];
		
		$email = $user->email;

		\Mail::send('emails.forgot_password', $data, function ($m) use ($email) {
			$m->from(config('system.from_email'),config('system.from'));
			$m->to($email)->subject('Forgot Password');
		});		
		
		return redirect('/login')->with('successMsg','New password has been send to your email.');
	}

	/**
	 * Logout user
	 * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
	 */
	public function logout()
	{
		
		if(\Auth::check())
		{
			\Auth::logout();
			session()->flush();
		}
		
		return redirect('/');
	}
}
