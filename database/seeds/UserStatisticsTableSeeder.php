<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNavPermission;

class UserStatisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addtoNavigationPermissionsTable();
        $this->addUserGroupToNavePermissionsTable();
    }

    public function addtoNavigationPermissionsTable()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'User List')->value('id');

        if(!DB::table('navigation_permissions')->where('navigation_id', '=', $navigation_id)->where('permission', '=', 'show_user_statistics_button')->count()){
            NavigationPermission::create([
                'navigation_id' => $navigation_id,
                'permission'    => 'show_user_statistics_button',
                'description'   => 'Show User Statistics Button'
            ]);
        }
    }

    public function addUserGroupToNavePermissionsTable()
    {
        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $navigation_id = DB::table('navigation')->where('name', '=', 'User List')->value('id');
        $permission_id = DB::table('navigation_permissions')->where('navigation_id', '=', $navigation_id)->where('permission', '=', 'show_user_statistics_button')->value('id');

        if(!UserGroupToNavPermission::where('user_group_id', '=', $adminID)->where('permission_id', '=', $permission_id)->count()){
            UserGroupToNavPermission::create(['user_group_id' => $adminID , 'permission_id' => $permission_id]);
        }
    }
}
