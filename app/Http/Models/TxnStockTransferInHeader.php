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
}
