<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppCustomer extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_customer';
	
	protected $timestamp = false;
}
