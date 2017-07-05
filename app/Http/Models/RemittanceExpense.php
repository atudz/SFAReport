<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemittanceExpense extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'remittance_expenses';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'remittance_id',
        'expense',
        'amount',
    ];
}