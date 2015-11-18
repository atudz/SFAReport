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
                ['name'=>'Dashboard','url'=>'/dashboard','class'=>'glyphicon glyphicon-dashboard','created_at' => new DateTime()],
        		['name'=>'Sales & Collection','url'=>'/reports/salescollection','class'=>'glyphicon glyphicon-list-alt','created_at' => new DateTime()],
        		['name'=>'Van Inventory','url'=>'/reports/vaninventory/canned','class'=>'glyphicon glyphicon-barcode','created_at' => new DateTime()],
        		['name'=>'Unpaid Invoice','url'=>'/reports/unpaid','class'=>'glyphicon glyphicon-credit-card','created_at' => new DateTime()],
                ['name'=>'Sales Report','url'=>'/reports/sales_report','class'=>'glyphicon glyphicon-stats','created_at' => new DateTime()],
        		['name'=>'BIR','url'=>'/reports/bir','class'=>'glyphicon glyphicon-th-list','created_at' => new DateTime()],
        		['name'=>'Sync Data','url'=>'/reports/sync','class'=>'glyphicon glyphicon-info-sign','created_at' => new DateTime()],
        		['name'=>'User Management','url'=>'/user','class'=>'glyphicon glyphicon-tasks','created_at' => new DateTime()],
        ];
    	DB::table('navigation')->insert($navigations);
    }
}
