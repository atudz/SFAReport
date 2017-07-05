<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remittance extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'remittances';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'sr_salesman_code',
        'jr_salesman_code',
        'date_from',
        'date_to',
        'cash_amount',
        'check_amount'
    ];

    public function getDateFromAttribute($value)
    {
        return date('m/d/Y',strtotime($value));
    }

    public function setDateFromAttribute($value)
    {
        $this->attributes['date_from'] = date('Y-m-d',strtotime($value));
    }

    public function getDateToAttribute($value)
    {
        return date('m/d/Y',strtotime($value));
    }

    public function setDateToAttribute($value)
    {
        $this->attributes['date_to'] = date('Y-m-d',strtotime($value));
    }

    /**
     * This model's relation to remittances
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sr_salesman()
    {
        return $this->belongsTo('App\Http\Models\AppSalesman', 'sr_salesman_code', 'salesman_code');
    }

    /**
     * This model's relation to remittances
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jr_salesman()
    {
        return $this->belongsTo('App\Http\Models\RdsSalesman', 'jr_salesman_code', 'salesman_code');
    }

    /**
     * This models't relation to remittances
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany('App\Http\Models\RemittanceExpense','remittance_id','id');
    }

    /**
     * This models't relation to remittances
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cash_breakdown()
    {
        return $this->hasMany('App\Http\Models\RemittanceCashBreakdown','remittance_id','id');
    }

}