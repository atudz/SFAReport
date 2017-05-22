<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupToNavOverride extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'user_group_to_nav_overrides';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = ['user_id','navigation_id','status'];

    public function getUserNavigations($user_id){
        return $this->where('user_id','=',$user_id)->select('navigation_id','status')->get();
    }
}