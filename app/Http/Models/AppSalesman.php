<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppSalesman extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_salesman';
	
	protected $timestamp = false;

	/**
	 * AppSalesman relation to AppSalesmanCustomer.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function salesmanCustomers()
	{
		return $this->belongsTo('App\Http\Models\AppSalesmanCustomer', 'salesman_code', 'salesman_code');
	}
}
