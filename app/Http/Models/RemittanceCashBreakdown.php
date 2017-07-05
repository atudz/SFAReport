<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemittanceCashBreakdown extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'remittance_cash_breakdowns';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'remittance_id',
        'denomination',
        'pieces'
    ];
}