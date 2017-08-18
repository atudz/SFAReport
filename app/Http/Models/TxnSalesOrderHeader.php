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
	
	public $timestamps = false;
	
	/**
	 * This model's relation to sales order detail
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details()
	{
		return $this->hasMany('App\Http\Models\TxnSalesOrderDetail','so_number','so_number');
	}
	
	/**
	 * This models' relation to customer
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
	{
		return $this->belongsTo('App\Http\Models\AppCustomer','customer_code','customer_code');
	}

	public function salesman()
	{
		return $this->belongsTo('App\Http\Models\AppSalesman','salesman_code','salesman_code');
	}

	public function activity_salesman()
	{
		return $this->hasOne('App\Http\Models\TxnActivitySalesman','reference_num','reference_num');
	}

	public function sales_order_header_discount()
	{
		return $this->hasOne('App\Http\Models\TxnSalesOrderHeaderDiscount','reference_num','reference_num');
	}

	public function sales_order_deal()
	{
		return $this->hasMany('App\Http\Models\TxnSalesOrderDeal','reference_num','reference_num');
	}
}
