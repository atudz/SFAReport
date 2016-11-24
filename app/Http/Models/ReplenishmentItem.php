<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class ReplenishmentItem extends ModelCore
{
    //
	protected $table = 'replenishment_item';
	
	/**
	 * This model's relation to replenishment
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function replenishment()
	{
		return $this->belongsTo('App\Models\Replenishment','reference_number','reference_number');
	}
}
