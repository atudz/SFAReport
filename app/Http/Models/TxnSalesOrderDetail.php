<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnSalesOrderDetail extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_sales_order_detail';
	
	protected $timestamp = false;
}
