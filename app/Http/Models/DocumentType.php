<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends ModelCore
{
    use SoftDeletes;

    /**
     * 
     * @var $table The table name
     */
    protected $table = 'document_types';

    protected $fillable = ['type','description'];
}