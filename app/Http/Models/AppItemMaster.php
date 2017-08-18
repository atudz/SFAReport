<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppItemMaster extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_item_master';
	
	public $timestamps = false;

	public function segment()
	{
		return $this->hasOne('App\Http\Models\SegmentCode','segment_code','segment_code');
	}
}
