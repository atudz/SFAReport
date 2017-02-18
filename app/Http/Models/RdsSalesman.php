<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class RdsSalesman extends ModelCore
{
    protected $table = 'rds_salesman';
    
    /**
     * This model's relation to app salesman
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salesman()
    {
    	return $this->belongsTo(AppSalesman::class,'salesman_code','salesman_code');
    }
    
}
