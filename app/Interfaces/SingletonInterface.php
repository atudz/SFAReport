<?php

namespace App\Interfaces;

/**
 *  The interface for Singletone objects
 * @author abner
 *
 */
interface SingletonInterface
{
	/**
	 * The clone magic method implementation for singletons
	 *
	 * Singletons can't be cloned, then you should trigger an error
	 * when implementing the __clone method.
	 */
	public function __clone();
	
}