<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupToNav extends ModelCore
{
	use SoftDeletes;

	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_group_to_nav';

	/**
	 * Required fields
	 * @var $fillable
	 */
	protected $fillable = ['user_group_id','navigation_id'];

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
	
	public function getGroupNavigations($user_group_id){
		return $this->where('user_group_id','=',$user_group_id)->lists('navigation_id');
	}
}
