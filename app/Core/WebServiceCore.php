<?php

namespace App\Core;

use App\Http\Controllers\Controller;


/**
 * This class is a wrapper class for Laravel's Controller.
 * Its mainly used for the core class for WebServices.
 * WebServices should extend this class
 *
 * @author abner
 *
 */

class WebServiceCore extends Controller
{
	/**
	 * Add customizations below
	 */
	
	/**
	 * 
	 * The json header
	 */
	const JSON_HEADER = 'Content-Type: application/json';
	
	/**
	 * The class constructor
	 */
	public function __construct()
	{
		
		// Make sure that header is always set to JSON
		header(self::JSON_HEADER);
		
	}
	
	/**
	 * Returns the WebService Classes directory
	 * @return string
	 */
	public static function getWebServiceDirectory()
	{
		return app_path('Http/WebServices/');
	}
}