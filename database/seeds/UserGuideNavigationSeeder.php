<?php

use Illuminate\Database\Seeder;

class UserGuideNavigationSeeder extends Seeder
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
            ['name'       => 'User Guide',
             'url'        => '',
             'class'      => 'glyphicon glyphicon-book',
             'order'      => 9,
             'created_at' => new DateTime(),
             'summary'    => 1
            ]
        ];
        DB::table('navigation')->insert($navigation_item);
        $userGuideID = DB::table('navigation')->where(['name' => 'User Guide'])->value('id');
        // Navigation sub menu items
        $navigation_item = [
            [
                'name'       => 'Admin',
                'url'        => 'adminuser.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 1,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Auditor',
                'url'        => 'auditoruser.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 2,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Accounting In Charge',
                'url'        => 'accountinginchargeuser.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 3,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Van Salesman',
                'url'        => 'vansalesmanuser.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 4,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Manager',
                'url'        => 'manageruser.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 5,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Guest 1',
                'url'        => 'guest1user.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 6,
                'created_at' => new DateTime()
            ],
            [
                'name'       => 'Guest 2', //$2y$10$Dtt4lH1/LWVVsI8NG4pJg.JmBHbx17X5RgCHG2n2gGW7JyyCgRhPq
                'url'        => 'guest2user.guide',
                'class'      => 'glyphicon glyphicon-share-alt',
                'parent_id'  => $userGuideID,
                'order'      => 7,
                'created_at' => new DateTime()
            ],

        ];
        DB::table('navigation')->insert($navigation_item);

        // adding new navigation for user admin.

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
        $accountingID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
        $vanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
        $manager = DB::table('user_group')->where(['name' => 'Manager'])->value('id');
        $guest1 = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
        $guest2 = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');

        if ($adminID) {
            //fetch all navigations
            $navs = [
                'User Guide',
                'Admin',
                'Auditor',
                'Accounting In Charge',
                'Van Salesman',
                'Manager',
                'Guest 1',
                'Guest 2'
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
                'User Guide',
                'Auditor',
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
                'User Guide',
                'Accounting In Charge',
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
                'User Guide',
                'Van Salesman',
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


        if ($manager) {
            //fetch all navigations
            $navs = [
                'User Guide',
                'Manager',
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $manager,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }

        if ($guest1) {
            //fetch all navigations
            $navs = [
                'User Guide',
                'Guest 1',
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
                'User Guide',
                'Guest 2'
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
