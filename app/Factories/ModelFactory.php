<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * Model class's factory
 */

class ModelFactory extends FactoryCore
{

	/**
	 * Creates a new instance for the class
	 * @param $className The class name without Controller prefix
	 */
	public static function getInstance($className)
	{
		$args = func_get_args();
		array_shift($args);
		return self::createInstance(self::getNamespace().$className);
	} 
	
	/**
	 * Get Model Class's namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Http\Models'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Model class name suffix
	 */
	public static function getSuffix()
	{
		return 'Models';
	}
	
}