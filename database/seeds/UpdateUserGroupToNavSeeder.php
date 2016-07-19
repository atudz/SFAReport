<?php

use Illuminate\Database\Seeder;

class UpdateUserGroupToNavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jrSalesmanID = DB::table('user_group')->where(['name'=>'Jr. Salesman'])->value('id');

        //fetch all navigations
        $navs = [
            'Sales & Collection',
            'Unpaid Invoice',
            'Van Inventory',
            'Sync Data',
            'Dashboard',
            'Sales Report',
            'Report',
            'Canned & Mixes',
            'Frozen & Kassel',
            'Per Material',
            'Peso Value',
            'Returns (Per Material)',
            'Returns (Peso Value)',
            'Master (Customer)',
            'Master (Material Price)',
        ];
        $mappings = [];
        foreach($navs as $nav)
        {
            if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
            {
                $mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$jrSalesmanID,'created_at' => new DateTime()];
            }
        }
        DB::table('user_group_to_nav')->insert($mappings);

    }
}
