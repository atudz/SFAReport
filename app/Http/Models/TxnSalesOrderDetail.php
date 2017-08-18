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
	
	public $timestamps = false;
	
	protected $appends = ['collective_discount_amount','total_sales'];

	/**
	 * This models' relation to sales order header
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sales()
	{
		return $this->belongsTo('App\Http\Models\TxnSalesOrderHeader','so_number','so_number');
	}
	
	/**
	 * This models' relation to sales order header
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function app_item_master()
	{
		return $this->belongsTo('App\Http\Models\AppItemMaster','item_code','item_code');
	}

	public function getCollectiveDiscountAmountAttribute()
	{
		$served_deduction_rate = !empty($this->sales->sales_order_header_discount) ? $this->sales->sales_order_header_discount->served_deduction_rate : 0;
		return number_format(round(($this->gross_served_amount + $this->vat_amount) * ($served_deduction_rate/100),2), 2, '.', '');
	}

	public function getTotalSalesAttribute()
	{
		$served_deduction_rate = !empty($this->sales->sales_order_header_discount) ? $this->sales->sales_order_header_discount->served_deduction_rate : 0;
		$sum_gross_served_amount_vat_amount = ($this->gross_served_amount + $this->vat_amount);

		return number_format($sum_gross_served_amount_vat_amount - ($this->discount_amount + ($sum_gross_served_amount_vat_amount * ($served_deduction_rate/100))), 2, '.', '');
	}
}
