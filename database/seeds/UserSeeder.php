<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('users')->insert([
    			'created_at' => new DateTime(), 
    			'user_group_pk_id' => '1', 
    			'fullname' => 'Accord Admin',		
    			'email' => 'admin1@accordhk.com',
    			'password' => bcrypt('ihpadmin'),
    			'created_by' => '1'
    	]);
    	
    }
}
