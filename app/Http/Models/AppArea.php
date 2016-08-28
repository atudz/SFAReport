<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppArea extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_area';
	
	protected $timestamp = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function contacts()
	{
		return $this->belongsTo('App\Http\Models\ContactUs');
	}
}
