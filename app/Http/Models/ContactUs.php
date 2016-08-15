<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class ContactUs extends ModelCore
{
    protected $table = 'contact_us';
    protected $fillable = [
        'full_name',
        'mobile',
        'telephone',
        'email',
        'location_assignment_code',
        'time_from',
        'time_to',
        'subject',
        'message',
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
