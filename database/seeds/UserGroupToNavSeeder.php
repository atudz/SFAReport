<?php

use Illuminate\Database\Seeder;

class UserGroupToNavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// fetch admin ID
    	$adminID = DB::table('user_group')->where(['name'=>'admin'])->value('id');
    	$therapistId = DB::table('user_group')->where(['name'=>'physiotherapist'])->value('id');
    	
    	if($adminID)
    	{
        	//fetch all navigations
        	$navs = ['Administrators','Physiotherapists','Exercises','Notifications','Reports'];
        	$mappings = [];
        	foreach($navs as $nav)
        	{
	        	if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
	        	{
	    			$mappings[] = ['navigation_pk_id'=>$menuId,'user_group_pk_id'=>$adminID,'created_at' => new DateTime()];
	    		}
        	}
    		DB::table('user_group_to_nav')->insert($mappings);
    	}
    	
    	if($therapistId)
    	{
    		//fetch all navigations
    		$navs = ['Profile','Patients List'];
    		$mappings = [];
    		foreach($navs as $nav)
    		{
    			if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
    			{
    				$mappings[] = ['navigation_pk_id'=>$menuId,'user_group_pk_id'=>$therapistId,'created_at' => new DateTime()];
    			}
    		}    	
    		DB::table('user_group_to_nav')->insert($mappings);
    	}
    	
    }
}
