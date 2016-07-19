<?php

use Illuminate\Database\Seeder;

class UpdateUserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group')->insert([
            ['name'=>'Jr. Salesman','created_at' => new DateTime()],
        ]);
    }
}
