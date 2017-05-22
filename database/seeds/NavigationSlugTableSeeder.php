<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Navigation;

class NavigationSlugTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slugs = [
            ['Dashboard','dashboard'],
            ['Sales & Collection','sales-and-collection'],
            ['Van Inventory','van-inventory'],
            ['Unpaid Invoice','unpaid-invoice'],
            ['Sales Report','sales-report'],
            ['BIR','bir'],
            ['Sync Data','sync-data'],
            ['User Management','user-management'],
            ['Report','report'],
            ['Posting','posting'],
            ['Monthly Summary of Sales','monthly-summary-of-sales'],
            ['Canned & Mixes','canned-and-mixes'],
            ['Frozen & Kassel','frozen-and-kassel'],
            ['Per Material','per-material'],
            ['Peso Value','peso-value'],
            ['Returns (Per Material)','returns-per-material'],
            ['Returns (Peso Value)','returns-peso-value'],
            ['Master (Customer)','master-customer'],
            ['Master (Salesman)','master-salesman'],
            ['Master (Material Price)','master-material-price'],
            ['User List','user-list'],
            ['Support Page','support-page'],
            ['Contact Us','contact-us'],
            ['Summary of Incident Report','summary-of-incident-report'],
            ['Stock Transfer','stock-transfer'],
            ['Stock Audit','stock-audit'],
            ['Flexi Deal','flexi-deal'],
            ['Actual Count Replenishment','actual-count-replenishment'],
            ['User Guide','user-guide'],
            ['Adjustment Replenishment','adjustment-replenishment'],
            ['Bounce Check','bounce-check-report'],
            ['Invoice Series Mapping','invoice-series-mapping'],
            ['Cash Payments','cash-payments'],
            ['Check Payments','check-payments'],
            ['Summary of Reversal','summary-of-reversal'],
            ['Open/Closing Period','open-closing-period'],
            ['User Access Matrix','user-access-matrix'],
            ['Role Access Matrix','role-access-matrix']
        ];

        foreach ($slugs as $slug) {
            Navigation::where('name','=',$slug[0])->update(['slug' => $slug[1]]);
        }
    }
}
