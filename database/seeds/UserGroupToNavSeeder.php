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
    	$adminID = DB::table('user_group')->where(['name'=>'Admin'])->value('id');
        $auditorID = DB::table('user_group')->where(['name'=>'Auditor'])->value('id');
        $accountingID = DB::table('user_group')->where(['name'=>'Accounting in charge'])->value('id');
    	$vanID = DB::table('user_group')->where(['name'=>'Van Salesman'])->value('id');
    	$guest1 = DB::table('user_group')->where(['name'=>'Guest1'])->value('id');
    	$guest2 = DB::table('user_group')->where(['name'=>'Guest2'])->value('id');
    	
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
        	'User List'
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
    	
    	if($auditorID)
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
            'Report',
            'Posting',
            'Monthly Summary of Sales',
            'Canned & Mixes',
            'Frozen & Kassel',
            'Per Material',
            'Peso Value',
            'Returns (Per Material)',
            'Returns (Peso Value)',
            'Master (Customer)',
        	'Master (Salesman)',
        	'Master (Material Price)',
            ];
            $mappings = [];
    		foreach($navs as $nav)
    		{
    			if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
    			{
    				$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$auditorID,'created_at' => new DateTime()];
    			}
    		}    	
    		DB::table('user_group_to_nav')->insert($mappings);
    	}

        if($accountingID)
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
            'Report',
            'Posting',            
            'Canned & Mixes',
            'Frozen & Kassel',
            'Per Material',
            'Peso Value',
            'Returns (Per Material)',
            'Returns (Peso Value)',
            'Master (Customer)',
        	'Master (Salesman)',
        	'Master (Material Price)',
            ];
            $mappings = [];
            foreach($navs as $nav)
            {
                if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
                {
                    $mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$accountingID,'created_at' => new DateTime()];
                }
            }       
            DB::table('user_group_to_nav')->insert($mappings);
        }

        if($vanID)
        {
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
                    $mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$vanID,'created_at' => new DateTime()];
                }
            }       
            DB::table('user_group_to_nav')->insert($mappings);
        }
        
        
        
        if($guest1)
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
        			$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$guest1,'created_at' => new DateTime()];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
        
        
        if($guest2)
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
        			'Master (Material Price)',
        	];
        	$mappings = [];
        	foreach($navs as $nav)
        	{
        		if($menuId = DB::table('navigation')->where('name','=',$nav)->value('id'))
        		{
        			$mappings[] = ['navigation_id'=>$menuId,'user_group_id'=>$guest2,'created_at' => new DateTime()];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
    	
    }
}
