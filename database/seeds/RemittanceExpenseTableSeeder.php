<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNav;
use App\Http\Models\UserGroupToNavPermission;

class RemittanceExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addRemittanceExpenseToNavigation();
        $this->addRemittanceExpensePermissionToNavigationPermissions();
        $this->setRemittanceExpenseUserGroupWithPermissionsToUserGroupToNav();
    }

    public function addRemittanceExpenseToNavigation()
    {
        if(!DB::table('navigation')->where('name', '=', 'Remittance/Expenses Report')->count()){

            DB::table('navigation')->insert([
                'name'       => 'Remittance/Expenses Report',
                'slug'       => 'remittance-expenses-report',
                'url'        => 'remittance.expenses.report',
                'class'      => 'glyphicon glyphicon-send',
                'parent_id'  => 0,
                'order'      => 15,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addRemittanceExpensePermissionToNavigationPermissions()
    {
        $navigation_id = DB::table('navigation')->where('slug', '=', 'remittance-expenses-report')->value('id');

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
                'permission'  => 'show_print',
                'description' => 'Show Print'
            ],
            [
                'permission'  => 'show_download',
                'description' => 'Show Download'
            ],
            [
                'permission'  => 'show_table',
                'description' => 'Show Remittance/Expenses Report Table'
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
                'permission'  => 'can_delete',
                'description' => 'Delete Remittance/Expenses Report'
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

    public function setRemittanceExpenseUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('slug', '=', 'remittance-expenses-report')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        $user_group_ids = [
            [
                'id' => $adminID,
                'permissions' => [
                    'show_add_button',
                    'show_filter',
                    'show_print',
                    'show_download',
                    'show_table',
                    'show_edit_button',
                    'show_delete_button',
                    'can_delete'
                ]
            ]
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
