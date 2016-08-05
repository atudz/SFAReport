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
            ['name'       => 'Support Page',
             'url'        => '',
             'class'      => 'glyphicon glyphicon-earphone',
             'order'      => 9,
             'created_at' => new DateTime(),
             'summary'    => 1
            ]
        ];
        DB::table('navigation')->insert($navigation_item);
        $supportPageID = DB::table('navigation')->where(['name' => 'Support Page'])->value('id');
        // Navigation sub menu items
        $navigation_item = [
            [
                'name'       => 'Contact Us',
                'url'        => 'contact.us',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $supportPageID,
                'order'      => 1,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Summary of Incident Report',
                'url'        => 'summaryofincident.report',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $supportPageID,
                'order'      => 2,
                'created_at' => new DateTime()
            ],

        ];
        DB::table('navigation')->insert($navigation_item);

        // adding new navigation for user admin.

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
        $accountingID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
        $vanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
        $guest1 = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
        $guest2 = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');

        if ($adminID) {
            //fetch all navigations
            $navs = [
                'Support Page',
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

        if ($auditorID) {
            //fetch all navigations
            $navs = [
                'Support Page',
                'Contact Us'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $auditorID,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }

        if ($accountingID) {
            //fetch all navigations
            $navs = [
                'Support Page',
                'Contact Us'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $accountingID,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }

        if ($vanID) {
            //fetch all navigations
            $navs = [
                'Support Page',
                'Contact Us'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $vanID,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }


        if ($guest1) {
            //fetch all navigations
            $navs = [
                'Support Page',
                'Contact Us'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $guest1,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }


        if ($guest2) {
            //fetch all navigations
            $navs = [
                'Support Page',
                'Contact Us'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $guest2,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }
    }
}
