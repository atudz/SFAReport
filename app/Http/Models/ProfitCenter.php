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

    protected $fillable = ['profit_center','area_code'];
    
    public function area()
    {
    	return $this->belongsTo(AppArea::class,'area_code','area_code');
    }
}