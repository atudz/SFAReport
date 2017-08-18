<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnActivitySalesman extends ModelCore
{
    /**
     * 
     * @var $table The table name
     */
    protected $table = 'txn_activity_salesman';

    public $timestamps = false;

    public function evaluated_objective()
    {
        return $this->hasMany('App\Http\Models\TxnEvaluatedObjective','reference_num','reference_num');
    }
}
