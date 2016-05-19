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
	
	/**
	 * This models' relation to sales order header
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sales()
	{
		return $this->belongsTo('App\Http\TxnSalesOrderHeader','so_number','so_number');
	}
}
