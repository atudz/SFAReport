<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfitCenter extends ModelCore
{
    use SoftDeletes;

    /**
     * 
     * @var $table The table name
     */
    protected $table = 'profit_centers';

    protected $fillable = ['profit_center','area_name'];
}