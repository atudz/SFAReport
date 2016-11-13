<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class Replenishment extends ModelCore
{
	protected $table = 'replenishment';
	
	protected $fillable = [
			'reference_num',
			'counted',
			'confirmed',
			'last_sr',
			'last_rprr',
			'last_cs',
			'last_dr',
			'last_ddr',
	];
	
	/**
	 * This model's relation to details
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rep()
	{
		return $this->hasOne('App\Http\Models\TxnReplenishmentHeader','reference_number','reference_num');
	}
}
