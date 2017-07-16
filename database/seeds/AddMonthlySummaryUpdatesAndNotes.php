<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNavPermission;

class AddMonthlySummaryUpdatesAndNotes extends Seeder
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

    // add mass edit button to navigation_permissions
    public function addtoNavigationPermissionsTable()
    {
        $navigation_id = DB::table('navigation')->where('slug', '=', 'monthly-summary-of-sales')->value('id');

        $permissions = [
            [
                'permission'  => 'show_add_updates_button',
                'description' => 'Show Add Updates Button'
            ],
            [
                'permission'  => 'show_edit_updates_button',
                'description' => 'Show Edit Updates Button'
            ],
            [
                'permission'  => 'show_delete_updates_button',
                'description' => 'Show Delete Updates Button'
            ],
            [
                'permission'  => 'show_add_notes_button',
                'description' => 'Show Add Notes Button'
            ],
            [
                'permission'  => 'show_delete_notes_button',
                'description' => 'Show Delete Notes Button'
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

    public function addUserGroupToNavePermissionsTable()
    {
        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $navigation_id = DB::table('navigation')->where('slug', '=', 'monthly-summary-of-sales')->value('id');

        $permissions = [
            'show_add_updates_button',
            'show_edit_updates_button',
            'show_delete_updates_button',
            'show_add_notes_button',
            'show_delete_notes_button',
        ];

        foreach ($permissions as $permission) {
            $permission_id = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->value('id');
            if(!UserGroupToNavPermission::where('user_group_id', '=', $adminID)->where('permission_id', '=', $permission_id)->count()){
                UserGroupToNavPermission::create(['user_group_id' => $adminID , 'permission_id' => $permission_id]);
            }
        }
    }
}
