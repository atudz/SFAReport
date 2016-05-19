<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReplenishmentDetail extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_replenishment_detail';
	
	protected $timestamp = false;
	
	/**
	 * This models' relation to replenishment
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function replenishment()
	{
		return $this->belongsTo('App\Http\TxnReplenishmentHeader','reference_number','reference_number');
	}
}
