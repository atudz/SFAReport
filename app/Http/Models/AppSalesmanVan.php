<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class AppSalesmanVan extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'app_salesman_van';
	
	public $timestamps = false;
	
	/**
	 * This model's relation to replenishment
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replenishment()
	{
		return $this->hasMany('App\Http\Models\TxnReplenishmentHeader','van_code','van_code');
	}
}
