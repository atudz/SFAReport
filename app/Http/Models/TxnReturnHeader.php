<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReturnHeader extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_return_header';
	
	protected $timestamp = false;
	
	/**
	 * This model's relation to sales order detail
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details()
	{
		return $this->hasMany('App\Http\Models\TxnReturnDetail','return_txn_number','return_txn_number');
	}
	
	/**
	 * This models' relation to customer
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
	{
		return $this->belongsTo('App\Http\Models\AppCustomer','customer_code','customer_code');
	}
}
