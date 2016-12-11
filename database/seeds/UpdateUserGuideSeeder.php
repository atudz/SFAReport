<?php

use Illuminate\Database\Seeder;

class UpdateUserGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group')->insert([
            ['name' => 'Supper Admin', 'created_at' => new DateTime()]
        ]);
        $supperAdminID = DB::table('user_group')->where(['name' => 'Supper Admin'])->value('id');
        if ($supperAdminID) {
            //fetch all navigations
            $navs = [
                'Sales & Collection',
                'Unpaid Invoice',
                'Van Inventory',
                'BIR',
                'Sync Data',
                'Dashboard',
                'Sales Report',
                'Report',
                'Posting',
                'Monthly Summary of Sales',
                'Canned & Mixes',
                'Frozen & Kassel',
                'Per Material',
                'Peso Value',
                'Returns (Per Material)',
                'Returns (Peso Value)',
                'User Management',
                'Master (Customer)',
                'Master (Salesman)',
                'Master (Material Price)',
                'User List',
                'Support Page',
                'Contact Us',
                'Summary of Incident Report',
                'User Guide',
                'Invoice Series Mapping',
                'Bounce Check',
                'AWOL RDS Report',
                'Stock Transfer',
                'Stock Audit Report',
                'Flexi Deal',
                'Actual Count Replenishment',
                'Adjustment Replenishment'
            ];
            $mappings = [];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    $mappings[] = [
                        'navigation_id' => $menuId,
                        'user_group_id' => $supperAdminID,
                        'created_at'    => new DateTime()
                    ];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        if ($adminID) {
            //fetch all navigations
            $navs = [
                'Admin',
                'Auditor',
                'Accounting In Charge',
                'Van Salesman',
                'Manager',
                'Guest 1',
                'Guest 2'
            ];
            foreach ($navs as $nav) {
                if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
                    DB::table('user_group_to_nav')->where('user_group_id', $adminID)->where('navigation_id',
                        $menuId)->delete();
                }
            }
        }

        $roles = [
            'Auditor',
            'Accounting In Charge',
            'Van Salesman',
            'Manager',
            'Guest 1',
            'Guest 2'
        ];

        foreach ($roles as $role) {
            $roleID = DB::table('user_group')->where(['name' => $role])->value('id');
            $menuId = DB::table('navigation')->where('name', '=', $role)->value('id');
            DB::table('user_group_to_nav')->where('user_group_id', $roleID)->where('navigation_id',
                $menuId)->delete();
        }

        $navigation_items = [
            [
                'name'       => 'Admin',
                'url'        => 'adminuser.guide',
            ],
            [
                'name'       => 'Auditor',
                'url'        => 'auditoruser.guide',
            ],
            [
                'name'       => 'Accounting In Charge',
                'url'        => 'accountinginchargeuser.guide',
            ],
            [
                'name'       => 'Van Salesman',
                'url'        => 'vansalesmanuser.guide',
            ],
            [
                'name'       => 'Manager',
                'url'        => 'manageruser.guide',
            ],
            [
                'name'       => 'Guest 1',
                'url'        => 'guest1user.guide',
            ],
            [
                'name'       => 'Guest 2',
                'url'        => 'guest2user.guide',
            ],

        ];

        foreach ($navigation_items as $navigation_item) {
            DB::table('navigation')->whereName($navigation_item['name'])->whereUrl($navigation_item['url'])->delete();
        }

        $navigation_item = [
            'name'       => 'User Guide',
            'url'        => 'user.guide',
            'class'      => 'glyphicon glyphicon-book',
            'order'      => 9,
            'created_at' => new DateTime(),
            'summary'    => 1
        ];
        DB::table('navigation')->whereName($navigation_item['name'])->update($navigation_item);
        DB::table('user')->insert([
            'created_at' => new DateTime(),
            'user_group_id' => $supperAdminID,
            'firstname' => 'Sfa',
            'lastname' => 'Supper Admin',
            'username' => 'supperadmin',
            'email' => 'supperadmin@email.com',
            'password' => bcrypt('p@ssw0rd!'),
            'created_by' => '1'
        ]);
    }
}
