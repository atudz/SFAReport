<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class SegmentCode extends ModelCore
{
    use SoftDeletes;

    /**
     * 
     * @var $table The table name
     */
    protected $table = 'segment_codes';

    protected $fillable = ['segment_code','description','abbreviation'];
}