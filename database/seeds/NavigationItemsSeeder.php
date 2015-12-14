<?php

use Illuminate\Database\Seeder;

class NavigationItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Navigation sub menu items
        $navigation_item = [
                ['name'=>'Report','url'=>'salescollection.report','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Posting','url'=>'salescollection.posting','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Monthly Summary','url'=>'salescollection.summary','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                
                ['name'=>'Canned & Mixes','url'=>'vaninventory.canned','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                ['name'=>'Frozen & Kassel','url'=>'vaninventory.frozen','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                
                ['name'=>'Per Material','url'=>'salesreport.permaterial','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Peso Value','url'=>'salesreport.pesovalue','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Per Material)','url'=>'salesreport.returnpermaterial','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Peso Value)','url'=>'salesreport.returnpesovalue','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		['name'=>'Customer List','url'=>'salesreport.customerlist','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		['name'=>'Salesman List','url'=>'salesreport.salesmanlist','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		['name'=>'Material Price List','url'=>'salesreport.materialpricelist','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		
        		['name'=>'User List','url'=>'user.list','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'8','created_at' => new DateTime()],
        		['name'=>'User Group Rights','url'=>'usergroup.rights','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'8','created_at' => new DateTime()],
        		
        ];
    	DB::table('navigation_item')->insert($navigation_item);
    }
}
