<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReplenishmentHeader extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'txn_replenishment_header';
	
	protected $timestamp = false;
	
	/**
	 * This model's relation to salesman van
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function salesman()
	{
		return $this->belongsTo('App\Http\Models\AppSalesmanVan','van_code','van_code');	
	}
	
	/**
	 * This model's relation to details
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details()
	{
		return $this->hasMany('App\Http\Models\TxnReplenishmentDetail','reference_number','reference_number');
	}
}
