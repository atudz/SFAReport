<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = new DateTime();
        $settings = [
        		'name'=>'synching_sfi',
        		'value'=>0,
        		'created_at'=>$now,
        		'updated_at'=>$now,
        ];
        \DB::table('settings')->insert($settings);
    }
}
