<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNavPermission;

class UserActivityLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addUserActivityLogToNavigation();

        $this->addUserActivityLogPermissionToNavigationPermission();

        $this->userActivityLogPermissions();
    }

    public function addUserActivityLogToNavigation(){
        if(!DB::table('navigation')->where('name', '=', 'User Activity Log')->count()){
            $parentId = DB::table('navigation')->where('name', '=', 'User Management')->value('id');

            DB::table('navigation')->insert([
                'name'       => 'User Activity Log',
                'slug'       => 'user-activity-log',
                'url'        => 'user.activity.log',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $parentId,
                'order'      => 4,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addUserActivityLogPermissionToNavigationPermission(){
        $ualId = DB::table('navigation')->where('name', '=', 'User Activity Log')->value('id');

        if(!NavigationPermission::where('navigation_id','=',$ualId)->count()){
            NavigationPermission::create([
                'navigation_id' => $ualId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ]);

            NavigationPermission::create([
                'navigation_id' => $ualId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ]);

            NavigationPermission::create([
                'navigation_id' => $ualId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ]);

            NavigationPermission::create([
                'navigation_id' => $ualId,
                'permission'    => 'show_table',
                'description'   => 'Show User Activity Logs Table'
            ]);

            NavigationPermission::create([
                'navigation_id' => $ualId,
                'permission'    => 'show_filter_user',
                'description'   => 'Show Filter User'
            ]);
        }
    }

    public function userActivityLogPermissions(){
        $ualId = DB::table('navigation')->where('name', '=', 'User Activity Log')->value('id');
        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!DB::table('user_group_to_nav')->where('navigation_id', '=', $ualId)->where('user_group_id', '=', $adminID)->count()){
            $permission = [
                'navigation_id' => $ualId,
                'user_group_id' => $adminID,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ];

            DB::table('user_group_to_nav')->insert($permission);
        }

        $adminUalPermissionIds = NavigationPermission::where('navigation_id','=',$ualId)->lists('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$adminID)->whereIn('permission_id',$adminUalPermissionIds)->count()){
            foreach ($adminUalPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $adminID,
                    'permission_id' => $id
                ]);
            }
        }

        $ualPermissionIds = NavigationPermission::where('navigation_id','=',$ualId)->whereNotIn('permission',['show_filter_user'])->lists('id');

        $auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$auditorID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $auditorID,
                    'permission_id' => $id
                ]);
            }
        }

        $accountingInChargeID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$accountingInChargeID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $accountingInChargeID,
                    'permission_id' => $id
                ]);
            }
        }

        $vanSalesmanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$vanSalesmanID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $vanSalesmanID,
                    'permission_id' => $id
                ]);
            }
        }

        $guest1ID = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$guest1ID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $guest1ID,
                    'permission_id' => $id
                ]);
            }
        }

        $guest2ID = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$guest2ID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $guest2ID,
                    'permission_id' => $id
                ]);
            }
        }

        $managerID = DB::table('user_group')->where(['name' => 'Manager'])->value('id');
        if(!UserGroupToNavPermission::where('user_group_id','=',$managerID)->whereIn('permission_id',$ualPermissionIds)->count()){
            foreach ($ualPermissionIds as $id) {
                UserGroupToNavPermission::create([
                    'user_group_id' => $managerID,
                    'permission_id' => $id
                ]);
            }
        }
    }
}
