<?php

use Illuminate\Database\Seeder;

class NavigationUserAccessMatrixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parentId = DB::table('navigation')->where('name', '=', 'User Management')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        // User Access Matrix
        $uamId = 0;
        if(DB::table('navigation')->where('name', '=', 'User Access Matrix')->count()){
            $uamId = DB::table('navigation')->where('name', '=', 'User Access Matrix')->value('id');

            DB::table('navigation')->where('id','=',$uamId)->update([
                'updated_at' => new DateTime(),
                'parent_id'  => $parentId, 
                'order'      => 3
            ]);
        } else {
            DB::table('navigation')->insert([
                'name'       => 'User Access Matrix',
                'url'        => 'user.access.matrix',
                'class'      => 'glyphicon glyphicon-user',
                'parent_id'  => $parentId,
                'order'      => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);

            $uamId = DB::table('navigation')->where('name', '=', 'User Access Matrix')->value('id');

            $uamMapping = [
                'navigation_id' => $uamId,
                'user_group_id' => $adminID,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ];

            DB::table('user_group_to_nav')->insert($uamMapping);
        }

        // Role Access Matrix
        if(!DB::table('navigation')->where('name', '=', 'Role Access Matrix')->count()){
            DB::table('navigation')->insert([
                'name'       => 'Role Access Matrix',
                'url'        => 'role.access.matrix',
                'class'      => 'glyphicon glyphicon-user',
                'parent_id'  => $parentId,
                'order'      => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);

            $ramId = DB::table('navigation')->where('name', '=', 'Role Access Matrix')->value('id');

            $ramMapping = [
                'navigation_id' => $ramId,
                'user_group_id' => $adminID,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ];
            DB::table('user_group_to_nav')->insert($ramMapping);
        }
    }
}
