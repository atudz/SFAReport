<?php

namespace App\Factories;

use App\Core\FactoryCore;

/**
 * Presenter class's factory
 */

class PresenterFactory extends FactoryCore
{
	
	/**
	 * Creates a new instance for the class
	 * @param $className The class name w/o Presenter prefix
	 */
	public static function getInstance($className)
	{
		$args = func_get_args();
		array_shift($args);
		return self::createInstance(self::getNamespace().$className.self::getSuffix(),$args);
	} 
	
	/**
	 * Get presenter class namespace root
	 */
	public static function getNamespace()
	{
		return 'App\Http\Presenters'.self::NAMESPACE_SEPARATOR;
	}
	
	/**
	 * Get Presenter class name suffix
	 */
	public static function getSuffix()
	{
		return 'Presenter';
	}
}