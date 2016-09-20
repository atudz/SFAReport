<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class File extends ModelCore
{
    protected $table = 'files';
    protected $fillable = ['path'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}
