<?php

namespace App\Core;

/**
 * Abstract class for Factory classes
 */
abstract class FactoryCore
{
	
	/**
	 * Holds the instances of the singletone classes
	 * @var singletons 
	 */
	static protected $singletones = [];
	
	
	/**
	 * The namespace separator character
	 */
	const NAMESPACE_SEPARATOR = '\\';
	

	/**
	 * Creates a new instance for the class
	 */
	public static function createInstance($className, $args = [])
	{
		
		$reflection = new \ReflectionClass($className);
		if($reflection->implementsInterface('App\Interfaces\SingletonInterface'))
		{
			if(isset(self::$singletones[$className]))
			{
				return self::$singletones[$className];
			}
			else 
			{
				$instance = ($args) ? $reflection->newInstanceArgs($args) :$reflection->newInstance();
				self::$singletones[$className] = $instance;
			}
		}
		else
		{
			$instance = ($args) ? $reflection->newInstanceArgs($args) :$reflection->newInstance();
		}
		
		return $instance;
	}
	
	/**
	 * Returns the Factory Classes directory
	 * @return string
	 */
	public static function getFactoryDirectory()
	{
		return app_path('Factories/');
	}
}