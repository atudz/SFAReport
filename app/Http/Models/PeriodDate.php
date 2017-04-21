<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class PeriodDate extends ModelCore
{
	protected $table = 'period_dates';

	protected $fillable = [
		'period_id',
		'period_date',
		'period_date_status'
	];
}
