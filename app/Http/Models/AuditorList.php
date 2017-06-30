<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditorList extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'auditors_list';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = [
        'auditor_id',
        'salesman_code',
        'area_code',
        'type',
        'period_from',
        'period_to'
    ];

    public function setPeriodFromAttribute($value)
    {
        $this->attributes['period_from'] = date('Y-m-d',strtotime($value));
    }

    public function setPeriodToAttribute($value)
    {
        $this->attributes['period_to'] = date('Y-m-d',strtotime($value));
    }

    /**
     * This model's relation to auditor's list
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'auditor_id', 'id');
    }

    /**
     * This model's relation to auditor's list
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salesman()
    {
        return $this->belongsTo('App\Http\Models\AppSalesman', 'salesman_code', 'salesman_code');
    }

    /**
     * This model's relation to auditor's list
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo('App\Http\Models\Area','area_code','area_code');
    }

}