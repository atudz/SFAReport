<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupToNavPermission extends ModelCore
{
	use SoftDeletes;

	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user_group_to_nav_permissions';

	/**
	 * Required fields
	 * @var $fillable
	 */
	protected $fillable = ['user_group_id','permission_id'];

	public function getGroupNavigationPermissions($user_group_id){
		return $this->where('user_group_id','=',$user_group_id)->lists('permission_id');
	}
}
