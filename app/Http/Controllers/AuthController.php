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
