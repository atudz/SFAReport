<?php

use Illuminate\Database\Seeder;

class SummaryReversalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$today = new DateTime();
    	 
    	// Navigation sub menu items
    	$navigation_item = [
    			['name'=>'Summary of Reversal','url'=>'reversal.summary','class'=>'glyphicon glyphicon-edit','parent_id'=>0,'order'=>13,'created_at' => $today,'updated_at'=>$today],
    	];
    	
    	DB::table('navigation')->insert($navigation_item);
    	 
    	$adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
    	
    	if ($adminID) {
    		//fetch all navigations
    		$navs = [
    				'Summary of Reversal'
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
    	 
    }
}
