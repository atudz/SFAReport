<?php

namespace App\Core;

/**
 * This is the core class for types.
 * All types should extend this class
 * 
 * @author abner
 *
 */

class TypeCore extends AttributeContainer
{
	
	/**
	 * Add customization below
	 */
	
	/**
	 * Returns the Type Classes directory
	 * @return string
	 */
	public static function getTypeDirectory()
	{
		return app_path('Types/');
	}
	
}