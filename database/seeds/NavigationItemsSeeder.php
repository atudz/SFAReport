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
                ['name'=>'Report','url'=>'/reports/salescollection','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Posting','url'=>'/reports/salescollection/posting','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                ['name'=>'Monthly Summary','url'=>'/reports/salescollection/monthlysummary','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'2','created_at' => new DateTime()],
                
                ['name'=>'Canned & Mixes','url'=>'/reports/vaninventory/canned','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                ['name'=>'Frozen & Kassel','url'=>'/reports/vaninventory/frozen','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'3','created_at' => new DateTime()],
                
                ['name'=>'Per Material','url'=>'/reports/sales_per_material','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Peso Value','url'=>'/reports/sales_per_value','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Per Material)','url'=>'/reports/returns_per_material','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
                ['name'=>'Returns (Peso Value)','url'=>'/reports/returns_per_value','class'=>'glyphicon glyphicon-share-alt','navigation_id'=>'5','created_at' => new DateTime()],
        		
        ];
    	DB::table('navigation_item')->insert($navigation_item);
    }
}
