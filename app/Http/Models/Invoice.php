<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends ModelCore
{
    //
    use SoftDeletes;
    
    protected $table = 'invoice';
    
    protected $fillable = [
    		'salesman_code',
    		'invoice_start',
    		'invoice_end',
    		'status'
    ];
}
