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
    			['name'=>'Admin','created_at' => new DateTime()],
                ['name'=>'Auditor','created_at' => new DateTime()],
                ['name'=>'Accounting in charge','created_at' => new DateTime()],
    			['name'=>'Van Salesman','created_at' => new DateTime()],
    			['name'=>'Guest1','created_at' => new DateTime()],
    			['name'=>'Guest2','created_at' => new DateTime()],
    	]);
    }
}
