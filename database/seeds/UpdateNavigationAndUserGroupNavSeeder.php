<?php

use Illuminate\Database\Seeder;

class UpdateNavigationAndUserGroupNavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Navigation sub menu items
        $navigation_item = [
            [
                'name'       => 'Contact Us',
                'url'        => 'contact.us',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => '8',
                'order'      => 2,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Summary of Incident Report',
                'url'        => 'summaryofincident.report',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => '8',
                'order'      => 3,
                'created_at' => new DateTime()
            ],

        ];
        DB::table('navigation')->insert($navigation_item);


        // adding new navigation for user admin.

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if ($adminID) {
            //fetch all navigations
            $navs = [
                'Contact Us',
                'Summary of Incident Report'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $adminID,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }
    }
}
