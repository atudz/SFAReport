<?php

use Illuminate\Database\Seeder;

class NavigationAddOpenClosingPeriodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navigation = [
            'name'       => 'Open/Closing Period',
            'url'        => 'openclosing.period',
            'class'      => 'glyphicon glyphicon-lock',
            'order'      => 14,
            'created_at' => new DateTime(),
            'summary'    => 0
        ];
        DB::table('navigation')->insert($navigation);

        $menuId = DB::table('navigation')->where('name', '=', 'Open/Closing Period')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        $mapping = [
            'navigation_id' => $menuId,
            'user_group_id' => $adminID,
            'created_at'    => new DateTime()
        ];

        DB::table('user_group_to_nav')->insert($mapping);
    }
}
