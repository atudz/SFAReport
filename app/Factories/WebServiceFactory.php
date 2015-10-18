<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * WebService class's factory
 */

class WebServiceFactory extends FactoryCore
{

	/**
	 * Creates a new instance for the class
	 * @param $className The class name without WebService prefix
	 */
	public static function getInstance($className)
	{
		$args = func_get_args();
		array_shift($args);
		return self::createInstance(self::getNamespace().$className.self::getSuffix(), $args);
	} 
	
	/**
	 * Get WebService Class's namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Http\WebServices'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Controller class name suffix
	 */
	public static function getSuffix()
	{
		return 'WebService';
	}
}