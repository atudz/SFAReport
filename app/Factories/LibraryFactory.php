<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * Library class's factory
 */

class LibraryFactory extends FactoryCore
{

	/**
	 * Creates a new instance for the class
	 * @param $className The class name without Library prefix
	 */
	public static function getInstance($className)
	{
		$args = func_get_args();
		array_shift($args);
		return self::createInstance(self::getNamespace().$className.self::getSuffix(), $args);
	} 
	
	/**
	 * Get Library Class's namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Libraries'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Library class name suffix
	 */
	public static function getSuffix()
	{
		return 'Library';
	}
}