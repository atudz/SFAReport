<?php

namespace App\Core;

use App\Http\Controllers\Controller;

/**
 * This class is a wrapper class for Laravel's Controller.
 * Its mainly used for the core class for the Controllers.
 * Controllers should extend this class
 * 
 * @author abner
 *
 */

class ControllerCore extends Controller
{
	
	/**
	 * Add customization below
	 */
	
	/**
	 * Returns the Controller Classes directory
	 * @return string
	 */

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['authenticate','resetPassword']]);
    }

	public static function getControllerDirectory()
	{
		return app_path('Http/Controllers/');
	}
	
}