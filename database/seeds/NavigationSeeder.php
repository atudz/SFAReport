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
                ['name'=>'Dashboard','url'=>'dashboard','class'=>'glyphicon glyphicon-dashboard','created_at' => new DateTime()],
        		['name'=>'Sales & Collection','url'=>'','class'=>'glyphicon glyphicon-list-alt','created_at' => new DateTime()],
        		['name'=>'Van Inventory','url'=>'','class'=>'glyphicon glyphicon-barcode','created_at' => new DateTime()],
        		['name'=>'Unpaid Invoice','url'=>'unpaid','class'=>'glyphicon glyphicon-credit-card','created_at' => new DateTime()],
                ['name'=>'Sales Report','url'=>'','class'=>'glyphicon glyphicon-stats','created_at' => new DateTime()],
        		['name'=>'BIR','url'=>'bir','class'=>'glyphicon glyphicon-th-list','created_at' => new DateTime()],
        		['name'=>'Sync Data','url'=>'sync','class'=>'glyphicon glyphicon-info-sign','created_at' => new DateTime()],
        		['name'=>'User Management','url'=>'','class'=>'glyphicon glyphicon-tasks','created_at' => new DateTime()],
        ];
    	DB::table('navigation')->insert($navigations);
    }
}