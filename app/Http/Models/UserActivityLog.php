<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class UserActivityLog extends ModelCore
{
	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_activity_logs';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = ['user_id','navigation_id','action_identifier','action'];

    /**
     * formatting created_at
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s A', strtotime($value));
    }

	/**
	 * This model's relation to user activity logs
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\Http\Models\User','user_id','id');
	}

	/**
	 * This model's relation to user activity logs
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function navigation()
	{
		return $this->belongsTo('App\Http\Models\Navigation','navigation_id','id');
	}
}