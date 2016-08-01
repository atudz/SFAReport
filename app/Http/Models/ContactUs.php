<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class ContactUs extends ModelCore
{
    protected $table = 'contact_us';
    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'location_assignment_code',
        'time_from',
        'time_to',
        'subject',
        'comment',
        'status'
    ];

    /**
     * Contact us relation to user table.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }
}
