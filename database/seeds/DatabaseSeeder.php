<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(NavigationSeeder::class);
        $this->call(UserGroupToNavSeeder::class);       
        $this->call(UserGroupToNavSeeder::class);
        $this->call(AddManagerSeeder::class);
		$this->call(CashPaymentsSeeder::class);
		$this->call(CheckPaymentSeeder::class);
		$this->call(StockTransferReportSeeder::class);

        Model::reguard();
    }
}
