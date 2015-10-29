<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupToNav extends ModelCore
{
/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_group_to_nav';

	/**
	 * UserGroupToNav relation to user_group table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group()
	{
		return $this->belongsTo('App\Http\Models\UserGroup', 'user_group_id');
	}

	/**
	 * UserGroupToNav relation to navigation table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function navigation()
	{
		return $this->belongsTo('App\Http\Models\Navigation', 'navigation_id');
	}
	
}
