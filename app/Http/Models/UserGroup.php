<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends ModelCore
{
/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_group';
	/**
	 * Let laravel set the created_at and updated_at value
	 * @var $timesamps
	 */

	/**
	 * UserGroup's relation to users table
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany('App\Http\Models\User', 'user_group_id');
	}

	/**
	 * UserGroup's relation to user_group_to_nav table
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function userGroupToNav()
	{
		return $this->hasMany('App\Http\Models\UserGroupToNav', 'user_group_id');
	}

	/**
	 * UserGroup's relation to navigation table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function navigations()
	{
		return $this->belongsToMany('App\Http\Models\Navigation','user_group_to_nav','user_group_id','navigation_id');
	}
	
	/**
	 * Query scope for filtering admins
	 * @param unknown $query
	 */
	public function scopeAdmin($query)
	{
		return $query->where('name','=','admin');
	}
	
	/**
	 * Query scope for filtering admins
	 * @param unknown $query
	 */
	public function scopeUser($query)
	{
		return $query->where('name','=','user');
	}
	
}
