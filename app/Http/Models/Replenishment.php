<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replenishment extends ModelCore
{
	
	use SoftDeletes;
	
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
