<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class Period extends ModelCore
{
	protected $table = 'periods';

	protected $fillable = [
		'company_code',
		'period_month',
		'period_year',
		'navigation_id',
		'period_status'
	];
}
