<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class UserPhone extends ModelCore
{
	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_phone';

	/**
	 * UserGroupToNav relation to user table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\Http\Models\User', 'user_id');
	}

	/**
	 * Query scope for filtering prirmary contact number
	 * @param unknown $query
	 */
	public function scopePrimary($query)
	{
		return $query->where('primary','=','1');
	}
	
}
