<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnSalesOrderHeader extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_sales_order_header';
	
	protected $timestamp = false;
}
