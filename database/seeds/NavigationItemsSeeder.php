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
                ['name'=>'Report','url'=>'/sales_collection_report','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Posting','url'=>'/sales_collection_posting','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Monthly Summary','url'=>'/monthly_summary','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                
                ['name'=>'Canned & Mixes','url'=>'/canned_mixes','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                ['name'=>'Frozen & Kassel','url'=>'/frozen_kassel','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                
                ['name'=>'Per Material','url'=>'/sales_per_material','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Peso Value','url'=>'/sales_per_value','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Per Material)','url'=>'/returns_per_material','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Peso Value)','url'=>'/returns_per_value','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		
        ];
    	DB::table('navigation_item')->insert($navigation_item);
    }
}
