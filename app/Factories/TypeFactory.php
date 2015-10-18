<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * Type class's factory
 */

class TypeFactory extends FactoryCore
{

	/**
	 * Creates a new instance for the class
	 * @param $className The class name without Controller prefix
	 */
	public static function getInstance($className)
	{
		$args = func_get_args();
		array_shift($args);
		return self::createInstance(self::getNamespace().$className.self::getSuffix(),$args);
	} 
	
	/**
	 * Get Type Class's namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Types'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Type class name suffix
	 */
	public static function getSuffix()
	{
		return 'Type';
	}
	
}