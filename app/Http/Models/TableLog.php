<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TableLog extends ModelCore
{
    protected $table = 'table_logs';
    protected $fillable = ['table', 'column', 'value', 'pk_id', 'updated_by', 'before', 'comment'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Contact us relation to user table.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Http\Models\User', 'updated_by');
    }
}
