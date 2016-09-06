<?php

use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Navigation main menu items
        $navigations = [
                ['name'=>'Dashboard','url'=>'dashboard','class'=>'glyphicon glyphicon-dashboard','order'=>1,'created_at' => new DateTime(),'summary'=>0],
        		['name'=>'Sales & Collection','url'=>'','class'=>'glyphicon glyphicon-list-alt','order'=>2,'created_at' => new DateTime(),'summary'=>1],
        		['name'=>'Van Inventory','url'=>'','class'=>'glyphicon glyphicon-barcode','order'=>3,'created_at' => new DateTime(),'summary'=>1],
        		['name'=>'Unpaid Invoice','url'=>'unpaid','class'=>'glyphicon glyphicon-credit-card','order'=>4,'created_at' => new DateTime(),'summary'=>1],
                ['name'=>'Sales Report','url'=>'','class'=>'glyphicon glyphicon-stats','order'=>5,'created_at' => new DateTime(),'summary'=>1],
        		['name'=>'BIR','url'=>'bir','class'=>'glyphicon glyphicon-th-list','order'=>6,'created_at' => new DateTime(),'summary'=>1],
        		['name'=>'Sync Data','url'=>'sync','class'=>'glyphicon glyphicon-info-sign','order'=>7,'created_at' => new DateTime(),'summary'=>1],
        		['name'=>'User Management','url'=>'','class'=>'glyphicon glyphicon-tasks','order'=>8,'created_at' => new DateTime(),'summary'=>0],
        ];
    	DB::table('navigation')->insert($navigations);
    	
    	
    	// Navigation sub menu items
    	$navigation_item = [
    			['name'=>'Report','url'=>'salescollection.report','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'2','order'=>1,'created_at' => new DateTime()],
    			['name'=>'Posting','url'=>'salescollection.posting','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'2','order'=>2,'created_at' => new DateTime()],
    			['name'=>'Monthly Sum of Sales','url'=>'salescollection.summary','class'=>'glyphicon glyphicon-share-alt','order'=>3,'parent_id'=>'2','created_at' => new DateTime()],
    	
    			['name'=>'Canned & Mixes','url'=>'vaninventory.canned','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'3','order'=>1,'created_at' => new DateTime()],
    			['name'=>'Frozen & Kassel','url'=>'vaninventory.frozen','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'3','order'=>2,'created_at' => new DateTime()],
    	
    			['name'=>'Per Material','url'=>'salesreport.permaterial','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>1,'created_at' => new DateTime()],
    			['name'=>'Peso Value','url'=>'salesreport.pesovalue','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>2,'created_at' => new DateTime()],
    			['name'=>'Returns (Per Material)','url'=>'salesreport.returnpermaterial','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>3,'created_at' => new DateTime()],
    			['name'=>'Returns (Peso Value)','url'=>'salesreport.returnpesovalue','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>4,'created_at' => new DateTime()],
    	
    			['name'=>'Master (Customer)','url'=>'salesreport.customerlist','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>5,'created_at' => new DateTime()],
    			['name'=>'Master (Salesman)','url'=>'salesreport.salesmanlist','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>6,'created_at' => new DateTime()],
    			['name'=>'Master (Material Price)','url'=>'salesreport.materialpricelist','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'5','order'=>7,'created_at' => new DateTime()],
    	
    			['name'=>'User List','url'=>'user.list','class'=>'glyphicon glyphicon-share-alt','parent_id'=>'8','order'=>1,'created_at' => new DateTime()],
    			//['name'=>'User Group Rights','url'=>'usergroup.rights','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'8','created_at' => new DateTime()],
    	
    	];
    	DB::table('navigation')->insert($navigation_item);
    	
    }
}
