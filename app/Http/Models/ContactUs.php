<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class ContactUs extends ModelCore
{
    protected $table = 'contact_us';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'location_assignment_code',
        'time_from',
        'time_to',
        'subject',
        'comment'
    ];
}
