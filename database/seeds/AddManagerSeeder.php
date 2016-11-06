<?php

use Illuminate\Database\Seeder;

class AddManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$today = new DateTime();
    	DB::table('user_group')->insert([
    			['name'=>'Manager','created_at' => $today,'updated_at'=>$today],
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
    				'Report',    				
    				'Canned & Mixes',
    				'Frozen & Kassel',
    				'Per Material',
    				'Peso Value',
    				'Returns (Per Material)',
    				'Returns (Peso Value)',
    				'Master (Customer)',
    				'Master (Salesman)',
    				'Master (Material Price)',
    				'Stock Transfer',
    				'Support Page',
    				'Contact Us',
    		];
    		$mappings = [];
    		$today = new DateTime();
    		foreach($navs as $nav)
    		{
    			if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
    			{
    				$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$manager,'created_at' => $today,'created_at' => $today];
    			}
    		}
    		DB::table('user_group_to_nav')->insert($mappings);
    	}
    }
}
