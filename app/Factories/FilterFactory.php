<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * Filter class's factory
 */

class FilterFactory extends FactoryCore
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
	 * Get Filter Class's namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Filters'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Filter class name suffix
	 */
	public static function getSuffix()
	{
		return 'Filter';
	}
	
}