<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class NavigationPermission extends ModelCore
{
	/**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'navigation_permissions';

	/**
	 * Required fields
	 * @var $fillable
	 */
	protected $fillable = ['navigation_id','permission','description'];
}