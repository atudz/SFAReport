<?php
namespace App\Core;

/**
 * This is the Core class for Library classes.
 * Each class should extend to this class.
 *
 * @author abner
 *
 */

class LibraryCore
{

	/**
	 * Add customization below
	 */

	/**
	 * Returns the Library Classes directory
	 * @return string
	 */
	public static function getLibraryDirectory()
	{
		return app_path('Libraries/');
	}

}