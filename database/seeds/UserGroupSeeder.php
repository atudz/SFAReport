<?php

use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('user_group')->insert([
    			['name'=>'admin','created_at' => new DateTime()],
    			['name'=>'user','created_at' => new DateTime()]
    	]);
    }
}
