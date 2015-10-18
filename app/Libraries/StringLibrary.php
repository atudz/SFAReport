<?php

namespace App\Libraries;

use App\Core\LibraryCore;
use App\Interfaces\SingletonInterface;

/**
 * This is a library class for String
 *
 * @author abner
 *
 */

class StringLibrary extends LibraryCore implements SingletonInterface
{
	/**
	 * Add customizations below
	 */
	public function __clone()
	{
		// throw exception here since Singleton can't be cloned
	}
}

