<?php

use Illuminate\Database\Seeder;

class StockTransferReportSeeder extends Seeder
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
        		['name'=>'Stock Transfer','url'=>'vaninventory.stocktransfer','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'3','order'=>3,'created_at' => $today,'updated_at'=>$today],        		        		 
        ];
        DB::table('navigation')->insert($navigation_item);
        
        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
        $auditorID = DB::table('user_group')->where(['name' => 'Auditor'])->value('id');
        $accountingID = DB::table('user_group')->where(['name' => 'Accounting in charge'])->value('id');
        $vanID = DB::table('user_group')->where(['name' => 'Van Salesman'])->value('id');
        $guest1 = DB::table('user_group')->where(['name' => 'Guest1'])->value('id');
        $guest2 = DB::table('user_group')->where(['name' => 'Guest2'])->value('id');
        
        if ($adminID) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',        			
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
        
        if ($auditorID) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',
        	];
        	$mappings = [];
        	foreach ($navs as $nav) {
        		if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
        			$mappings[] = [
        					'navigation_id' => $menuId,
        					'user_group_id' => $auditorID,
        					'created_at'    => new DateTime()
        			];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
        
        if ($accountingID) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',
        	];
        	$mappings = [];
        	foreach ($navs as $nav) {
        		if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
        			$mappings[] = [
        					'navigation_id' => $menuId,
        					'user_group_id' => $accountingID,
        					'created_at'    => new DateTime()
        			];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
        
        if ($vanID) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',
        	];
        	$mappings = [];
        	foreach ($navs as $nav) {
        		if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
        			$mappings[] = [
        					'navigation_id' => $menuId,
        					'user_group_id' => $vanID,
        					'created_at'    => new DateTime()
        			];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
        
        
        if ($guest1) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',
        	];
        	$mappings = [];
        	foreach ($navs as $nav) {
        		if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
        			$mappings[] = [
        					'navigation_id' => $menuId,
        					'user_group_id' => $guest1,
        					'created_at'    => new DateTime()
        			];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
        
        
        if ($guest2) {
        	//fetch all navigations
        	$navs = [
        			'Stock Transfer',
        	];
        	$mappings = [];
        	foreach ($navs as $nav) {
        		if ($menuId = DB::table('navigation')->where('name', '=', $nav)->value('id')) {
        			$mappings[] = [
        					'navigation_id' => $menuId,
        					'user_group_id' => $guest2,
        					'created_at'    => new DateTime()
        			];
        		}
        	}
        	DB::table('user_group_to_nav')->insert($mappings);
        }
    }
}
