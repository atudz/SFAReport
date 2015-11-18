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
    	$userID = DB::table('user_group')->where(['name'=>'user'])->value('id');
    	
    	if($adminID)
    	{
        	//fetch all navigations
        	$navs = [
            'Sales & Collection',
            'Unpaid Invoice',
            'Van Inventory',
            'BIR',
            'Sync Data',
            'Dashboard',
            'Sales Report',
            'Sales & Collection Report',
            'Sales & Collection Posting',
            'Monthly Summary Sales Report',
            'Canned & Mixes',
            'Frozen & Kassel',
            'Sales Report (Per Material)',
            'Sales Report (Peso Value)',
            'Returns (Per Material)',
            'Returns (Peso Value)',
            'User Management'
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
    	
    	if($userID)
    	{
    		//fetch all navigations
    		$navs = [
            'Sales & Collection',
            'Unpaid Invoice',
            'Van Inventory',
            'BIR',
            'Sync Data',
            'Dashboard',
            'Sales Report',
            'Sales & Collection Report',
            'Sales & Collection Posting',
            'Monthly Summary Sales Report',
            'Canned & Mixes',
            'Frozen & Kassel',
            'Sales Report (Per Material)',
            'Sales Report (Peso Value)',
            'Returns (Per Material)',
            'Returns (Peso Value)'
            ];
            $mappings = [];
    		foreach($navs as $nav)
    		{
    			if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
    			{
    				$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$userID,'created_at' => new DateTime()];
    			}
    		}    	
    		DB::table('user_group_to_nav')->insert($mappings);
    	}
    	
    }
}
