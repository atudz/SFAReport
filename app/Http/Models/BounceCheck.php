<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class BounceCheck extends ModelCore
{
	use SoftDeletes;
	
	protected $table = 'bounce_check';
	
	protected $fillable = [
			'txn_number',
			'jr_salesman_id',
			'salesman_code',
			'area_code',
			'customer_code',
			'dm_number',
			'dm_date',
			'invoice_number',
			'invoice_date',
			'bank_name',
			'account_number',
			'cheque_number',
			'cheque_date',
			'reason',
			'original_amount',
			'payment_amount',
			'balance_amount',
			'remarks',
	];
	
	/**
	 * This model's relation to user
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function jr_salesman()
	{
		return $this->belongsTo('App\Http\Models\User','jr_salesman_id');
	}
	
	/**
	 * This model's relation to user
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function area()
	{
		return $this->belongsTo('App\Http\Models\Area','area_code','area_code');
	}
	
	/**
	 * This model's relation to user
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('App\Http\Models\User','created_by');
	}
}
