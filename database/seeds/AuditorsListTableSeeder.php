<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNav;
use App\Http\Models\UserGroupToNavPermission;

class AuditorsListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addAuditorsListToNavigation();
        $this->addAuditorsListPermissionToNavigationPermissions();
        $this->setAuditorsListUserGroupWithPermissionsToUserGroupToNav();
    }

    public function addAuditorsListToNavigation()
    {
        if(!DB::table('navigation')->where('name', '=', 'Auditors List')->count()){
            $parentId = DB::table('navigation')->where('slug', '=', 'van-inventory')->value('id');

            DB::table('navigation')->insert([
                'name'       => 'Auditors List',
                'slug'       => 'auditors-list',
                'url'        => 'auditors.list',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $parentId,
                'order'      => 6,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addAuditorsListPermissionToNavigationPermissions()
    {
        $navigation_id = DB::table('navigation')->where('slug', '=', 'auditors-list')->value('id');

        $permissions = [
            [
                'permission'  => 'show_add_button',
                'description' => 'Show Add New User Button'
            ],
            [
                'permission'  => 'show_filter',
                'description' => 'Show Filter'
            ],
            [
                'permission'  => 'show_table',
                'description' => 'Show User List Table'
            ],
            [
                'permission'  => 'show_edit_button',
                'description' => 'Show Edit Button'
            ],
            [
                'permission'  => 'show_delete_button',
                'description' => 'Show Delete Button'
            ],
            [
                'permission'  => 'can_save',
                'description' => 'Create Auditor\'s List'
            ],
            [
                'permission'  => 'can_update',
                'description' => 'Update Auditor\'s List'
            ],
            [
                'permission'  => 'can_delete',
                'description' => 'Delete Auditor\'s List'
            ],
            [
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Auditor\'s Table Columns'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function setAuditorsListUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('slug', '=', 'auditors-list')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
        $accountingInChargeID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
        $vanSalesmanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
        $managerID = DB::table('user_group')->where(['name' => 'Manager'])->value('id');
        $guest1ID = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
        $guest2ID = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');


        $user_group_ids = [
            [
                'id' => $adminID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'show_edit_button',
                    'show_delete_button',
                    'can_save',
                    'can_update',
                    'can_delete',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $auditorID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $accountingInChargeID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $vanSalesmanID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $managerID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $guest1ID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
            [
                'id' => $guest2ID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_table',
                    'can_save',
                    'show_print',
                    'show_download',
                    'can_sort_columns'
                ]
            ],
        ];

        foreach ($user_group_ids as $user_group_id) {
            if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $user_group_id['id'])->count()){
                UserGroupToNav::create([
                    'user_group_id' => $user_group_id['id'],
                    'navigation_id' => $navigation_id
                ]);
            }

            foreach ($user_group_id['permissions'] as $permission) {
                $permission = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();
                if(!UserGroupToNavPermission::where('permission_id', '=', $permission->id)->where('user_group_id', '=', $user_group_id['id'])->count()){
                    UserGroupToNavPermission::create([
                        'user_group_id' => $user_group_id['id'],
                        'permission_id' => $permission->id
                    ]);
                }
            }
        }
    }
}
