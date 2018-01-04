<?php

use Illuminate\Database\Seeder;
use App\Factories\ModelFactory;
use Carbon\Carbon;

class Task0000736FixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(ModelFactory::getInstance('AppSalesman')->where('salesman_code','L06')->count())
        {
            ModelFactory::getInstance('AppSalesman')
                ->where('salesman_code','L06')
                ->update([
                    'salesman_name' => 'ALBA, IÑIGO',
                    'updated_at'    => Carbon::now(),
                    'updated_by'    => 1
                ]);
        }
    }
}
