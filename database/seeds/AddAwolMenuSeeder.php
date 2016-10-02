<?php

use Illuminate\Database\Seeder;

class AddAwolMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$navigations = [
    			['name'=>'AWOL RDS Report','url'=>'http://121.96.255.197:2381/','class'=>'fa fa-sign-in','order'=>9,'created_at' => new DateTime(),'summary'=>1,'link'=>'1'],    			
    	];
    	DB::table('navigation')->insert($navigations);
    	
    	$adminID = DB::table('user_group')->where(['name'=>'Admin'])->value('id');
    	 
    	if($adminID)
    	{
    		//fetch all navigations
    		$navs = [
    				'AWOL RDS Report',    				
    		];
    		$mappings = [];
    		foreach($navs as $nav)
    		{
    			if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
    			{
    				$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$adminID,'created_at' => new DateTime()];
    			}
    		}
    		DB::table('user_group_to_nav')->insert($mappings);
    	}
    }
}
