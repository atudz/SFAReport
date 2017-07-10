<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlySummaryUpdate extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'monthly_summary_updates';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'salesman_code',
        'remarks',
        'summary_date',
        'total_collected_amount',
        'sales_tax',
        'amount_for_commission'
    ];
}