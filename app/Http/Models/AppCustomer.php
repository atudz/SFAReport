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
	
	protected $timestamp = false;
	
	/**
	 * This model's relation to sales order
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sales()
	{
		return $this->hasMany('App\Http\Models\TxnSalesOrderHeader','customer_code','customer_code');
	}
}
