<?php

use Illuminate\Database\Seeder;
use App\Http\Models\NavigationPermission;
use App\Http\Models\Navigation;
use App\Http\Models\UserGroupToNavPermission;

class Task0000715TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids = $this->addNavigationPermissions();

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        $this->addNavigationPermissionIdToUserGroupToNavPermission($adminID,$permission_ids);
    }

    public function addNavigationPermissions()
    {
        $navigations = [
            'Report',
            'Posting',
            'Cash Payments',
            'Check Payments',
            'Canned & Mixes',
            'Frozen & Kassel',
            'Flexi Deal',
            'Per Material',
            'Peso Value',
            'Returns (Per Material)',
            'Returns (Peso Value)',
            'Unpaid Invoice',
            'BIR'
        ];

        $navigation_ids = [];

        foreach ($navigations as $navigation) {
            $navigation_ids[] = Navigation::where('name', '=', $navigation)->value('id');
        }

        $permission_ids = [];
        $permissions = [
            [
                'permission'    => 'show_delete_remarks_column',
                'description'   => 'Show Delete Remarks Column'
            ],
            [
                'permission'    => 'edit_delete_remarks_column',
                'description'   => 'Edit Delete Remarks Column'
            ]
        ];

        foreach ($navigation_ids as $navigation_id) {
            foreach ($permissions as $permission) {
                if(!NavigationPermission::where('permission', '=', $permission['permission'])->where('navigation_id', '=', $navigation_id)->count()){
                    $created_permission = NavigationPermission::create(array_merge(['navigation_id' => $navigation_id],$permission));
                    $permission_ids[] = $created_permission->id;
                }
            }
        }

        return $permission_ids;
    }

    public function addNavigationPermissionIdToUserGroupToNavPermission($user_group_id,$permission_ids)
    {
        foreach ($permission_ids as $permission_id) {
            if(!UserGroupToNavPermission::where('user_group_id', '=' , $user_group_id)->where('permission_id', '=' , $permission_id)->count()){
                UserGroupToNavPermission::create([
                    'user_group_id' => $user_group_id,
                    'permission_id' => $permission_id
                ]);
            }
        }
    }
}
