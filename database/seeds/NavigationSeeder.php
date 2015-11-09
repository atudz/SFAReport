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
        		['name'=>'Sales & Collection','url'=>'/sales','created_at' => new DateTime()],
        		['name'=>'Unpaid Invoice','url'=>'/invoice','created_at' => new DateTime()],
        		['name'=>'Van Inventory & History','url'=>'/inventory','created_at' => new DateTime()],
        		['name'=>'BIR','url'=>'/bir','created_at' => new DateTime()],
        		['name'=>'Sync Data','url'=>'/sync','created_at' => new DateTime()],
        		['name'=>'User Management','url'=>'/user','created_at' => new DateTime()],
        		
        ];
    	DB::table('navigation')->insert($navigations);
    }
}
