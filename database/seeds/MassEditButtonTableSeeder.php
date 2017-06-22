<?php

use Illuminate\Database\Seeder;

use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNavPermission;

class MassEditButtonTableSeeder extends Seeder
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

    public function reportIds(){
        $report_navigation_id = DB::table('navigation')->where('slug', '=', 'report')->value('id');
        $canned_and_mixes_navigation_id = DB::table('navigation')->where('slug', '=', 'canned-and-mixes')->value('id');
        $frozen_and_kassel_navigation_id = DB::table('navigation')->where('slug', '=', 'frozen-and-kassel')->value('id');
        $stock_transfer_navigation_id = DB::table('navigation')->where('slug', '=', 'stock-transfer')->value('id');
        $per_material_navigation_id = DB::table('navigation')->where('slug', '=', 'per-material')->value('id');
        $peso_value_navigation_id = DB::table('navigation')->where('slug', '=', 'peso-value')->value('id');

        return [
            $report_navigation_id,
            $canned_and_mixes_navigation_id,
            $frozen_and_kassel_navigation_id,
            $stock_transfer_navigation_id,
            $per_material_navigation_id,
            $peso_value_navigation_id
        ];
    }

    // add mass edit button to navigation_permissions
    public function addtoNavigationPermissionsTable()
    {
        foreach ($this->reportIds() as $id) {
            if(!NavigationPermission::where('navigation_id', '=', $id)->where('permission', '=', 'show_mass_edit_button')->count()){
                NavigationPermission::create([
                    'navigation_id' => $id,
                    'permission'    => 'show_mass_edit_button',
                    'description'   => 'Show Mass Edit Button'
                ]);
            }
        }
    }

    public function addUserGroupToNavePermissionsTable()
    {
        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        foreach ($this->reportIds() as $id) {
            $permission_id = NavigationPermission::where('navigation_id', '=', $id)->where('permission', '=', 'show_mass_edit_button')->value('id');

            if(!UserGroupToNavPermission::where('user_group_id', '=', $adminID)->where('permission_id', '=', $permission_id)->count()){
                UserGroupToNavPermission::create(['user_group_id' => $adminID , 'permission_id' => $permission_id]);
            }
        }
    }
}
