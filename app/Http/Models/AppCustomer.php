<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppCustomer extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_customer';
	
	public $timestamps = false;
	
	/**
	 * This model's relation to sales order
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sales()
	{
		return $this->hasMany('App\Http\Models\TxnSalesOrderHeader','customer_code','customer_code');
	}

	/**
	 * AppCustomer relation to AppSalesmanCustomer.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function salesmanCustomers()
	{
		return $this->belongsTo('App\Http\Models\AppSalesmanCustomer', 'customer_code', 'customer_code');
	}

	public function area()
	{
		return $this->belongsTo('App\Http\Models\AppArea', 'area_code', 'area_code');
	}
}
