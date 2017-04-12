<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnStockTransferInDetail extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_stock_transfer_in_detail';
	
	public $timestamps = false;
	
	/**
	 * This models' relation to stock transfer header
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function stock()
	{
		return $this->belongsTo('App\Http\TxnStockTransferInHeader','stock_transfer_number','stock_transfer_number');
	}
}
