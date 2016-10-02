<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UpdateSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'name'=>'max_file_size',
            'value'=>10,
            'created_at'=> Carbon::now(),
            'updated_at'=>Carbon::now(),
        ];
        \DB::table('settings')->insert($settings);

    }
}
