<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupToNavPermissionOverride extends ModelCore
{
    use SoftDeletes;

    /**
     * The table name
     * @var $table
     */
    protected $table = 'user_group_to_nav_permission_overrides';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = ['user_id','permission_id','status'];

    public function getUserNavigationPermissions($user_id){
        return $this->where('user_id','=',$user_id)->select('permission_id','status')->get();
    }
}