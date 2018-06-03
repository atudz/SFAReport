<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class GLAccount extends ModelCore
{
    use SoftDeletes;

    /**
     * 
     * @var $table The table name
     */
    protected $table = 'gl_accounts';

    protected $fillable = ['code','description'];
}