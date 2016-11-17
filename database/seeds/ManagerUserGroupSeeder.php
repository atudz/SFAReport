<?php

use Illuminate\Database\Seeder;

class ManagerUserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group')->insert([
            ['name' => 'Manager', 'created_at' => new DateTime()],
        ]);

        $manager = DB::table('user_group')->where(['name'=>'Manager'])->value('id');

        if($manager)
        {
            //fetch all navigations
            $navs = [
                'Sales & Collection',
                'Unpaid Invoice',
                'Van Inventory',
                'Dashboard',
                'Sales Report',
                'BIR',
                'Sales & Collection Report',
                'Canned & Mixes',
                'Frozen & Kassel',
                'Per Material',
                'Peso Value',
                'Returns (Per Material)',
                'Returns (Peso Value)',
                'Master (Customer)',
                'Master (Material Price)',
                'Master (Salesman)',
            ];
            $mappings = [];
            foreach($navs as $nav)
            {
                if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
                {
                    $mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$manager,'created_at' => new DateTime()];
                }
            }
            DB::table('user_group_to_nav')->insert($mappings);
        }
    }
}
