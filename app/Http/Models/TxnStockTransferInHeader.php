<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnStockTransferInHeader extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_stock_transfer_in_header';
	
	protected $timestamp = false;
	
	/**
	 * This model's relation to stock transfer details
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details()
	{
		return $this->hasMany('App\Http\Models\TxnStockTransferInDetail','stock_transfer_number','stock_transfer_number');
	}
}
