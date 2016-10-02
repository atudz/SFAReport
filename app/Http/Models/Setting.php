<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class Setting extends ModelCore
{
    protected $table = 'settings';
    protected $fillable = ['name', 'value'];
    protected $dates = ['created_at', 'updated_at'];
}
