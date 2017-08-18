<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnSalesOrderDeal extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_sales_order_deal';
	
	public $timestamps = false;
}