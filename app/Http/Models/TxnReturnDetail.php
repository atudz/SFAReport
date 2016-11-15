<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReturnDetail extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_return_detail';
	
	public $timestamps = false;
	
	/**
	 * This models' relation to return header
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function returns()
	{
		return $this->belongsTo('App\Http\TxnReturnHeader','return_txn_number','return_txn_number');
	}
}
