<?php

use Illuminate\Database\Seeder;

class InvoiceSeriesMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$today = new DateTime();
    	
    	$navigation_item = [
    			['name'=>'Invoice Series Mapping','url'=>'invoiceseries.mapping','class'=>'glyphicon glyphicon-tag','parent_id'=>0,'order'=>11,'created_at' => $today,'updated_at'=>$today],
    	];
    	
    	DB::table('navigation')->insert($navigation_item);
    	
    	$adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
//     	$auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
//     	$accountingID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
//     	$vanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
//     	$guest1 = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
//     	$guest2 = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');
//     	$manager = DB::table('user_group')->where(['name' => 'Manager'])->value('id');
    	
    	if ($adminID) {
    		//fetch all navigations
    		$navs = [
    				'Invoice Series Mapping'
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
    	
//     	if ($auditorID) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $auditorID,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    	
//     	if ($accountingID) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $accountingID,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    	
//     	if ($vanID) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $vanID,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    	
    	
//     	if ($guest1) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $guest1,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    	
    	
//     	if ($guest2) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $guest2,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    	
//     	if ($manager) {
//     		//fetch all navigations
//     		$navs = [
//     				'Invoice Series Mapping'
//     		];
//     		$mappings = [];
//     		foreach ($navs as $nav) {
//     			if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
//     				$mappings[] = [
//     						'navigation_id' => $menuId,
//     						'user_group_id' => $manager,
//     						'created_at'    => new DateTime()
//     				];
//     			}
//     		}
//     		DB::table('user_group_to_nav')->insert($mappings);
//     	}
    }
}
