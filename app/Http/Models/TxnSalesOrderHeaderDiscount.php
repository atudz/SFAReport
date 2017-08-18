<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnSalesOrderHeaderDiscount extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_sales_order_header_discount';
	
	public $timestamps = false;
}