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
        		['name'=>'Administrators','url'=>'/admin','created_at' => new DateTime()],
        		['name'=>'Physiotherapists','url'=>'/therapist','created_at' => new DateTime()],
        		['name'=>'Exercises','url'=>'/exercises','created_at' => new DateTime()],
        		['name'=>'Reports','url'=>'','created_at' => new DateTime()],
        		['name'=>'Profile','url'=>'/profile','created_at' => new DateTime()],
        		['name'=>'Patients List','url'=>'/patients','created_at' => new DateTime()],
        		['name'=>'Notifications','url'=>'/notification','created_at' => new DateTime()],
        		
        ];
    	DB::table('navigation')->insert($navigations);
    }
}
