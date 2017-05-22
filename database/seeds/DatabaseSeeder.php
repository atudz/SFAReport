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
        $this->call(StockTransferReportSeeder::class);
        $this->call(UpdateNavigationAndUserGroupNavSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(UpdateSettingsSeeder::class);
        $this->call(AddManagerSeeder::class);
//        $this->call(StatementOfShortagesSeeder::class);
        $this->call(RdsSalesmanSeeder::class);
        $this->call(StockAuditReportSeeder::class);
        $this->call(FlexiDealReportSeeder::class);
        $this->call(ActualCountReplenishmentSeeder::class);
        $this->call(ReplenishmentAdjustmentSeeder::class);
        $this->call(InvoiceSeriesMappingSeeder::class);
        $this->call(BounceCheckSeeder::class);
        $this->call(UserGuideNavigationSeeder::class);
//        $this->call(UpdateUserGuideSeeder::class);
		$this->call(CashPaymentsSeeder::class);

		$this->call(CheckPaymentSeeder::class);
		$this->call(OrganizeNavsSeeder::class);

        // Access Matrix Table
        $this->call(NavigationUserAccessMatrixTableSeeder::class);
        $this->call(NavigationPermissionTableSeeder::class);
        $this->call(DefaultNavigationPermissionsTableSeeder::class);
        $this->call(NavigationSlugTableSeeder::class);
        Model::reguard();
    }
}
