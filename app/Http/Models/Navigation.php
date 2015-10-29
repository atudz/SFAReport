<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class Navigation extends ModelCore
{
/**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'navigation';

	
	/**
	 * Navigation relation to user_group_to_nav table
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function userGroupToNav()
	{
		return $this->hasMany('App\Http\Models\UserGroupToNav', 'navigation_id');
	}
	
	/**
	 * Navigation relation to navigation_item table
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function item()
	{
		return $this->hasMany('App\Http\Models\NavigationItem', 'navigation_id');
	}

	/**
	 * Navigation's relation to user_group table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function userGroup()
	{
		return $this->belongsToMany('UserGroup');
	}
}
