<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppSalesmanCustomer extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_salesman_customer';
	
	public $timestamps = false;

	/**
	 * AppSalesmanCustomer relation to AppSalesman.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function salesmans()
	{
		return $this->hasMany('App\Http\Models\AppSalesman', 'salesman_code', 'salesman_code');
	}

	/**
	 * AppSalesmanCustomer relation to AppCustomer.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function customers()
	{
		return $this->hasMany('App\Http\Models\AppCustomer', 'customer_code', 'customer_code');
	}
}
