<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends ModelCore
{
	/**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'navigation_item';
	
	/**
	 * Navigation item relation to navigation table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function navigation()
	{
		return $this->belongsTo('App\Http\Models\Navigation', 'navigation_id');
	}
}
