<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlySummaryNote extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'monthly_summary_notes';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'salesman_code',
        'notes',
        'summary_date'
    ];
}