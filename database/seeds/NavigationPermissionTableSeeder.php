<?php

use Illuminate\Database\Seeder;
use App\Http\Models\NavigationPermission;

class NavigationPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $syncId = DB::table('navigation')->where('name', '=', 'Sync Data')->value('id');

        $userListId = DB::table('navigation')->where('name', '=', 'User List')->value('id');

        $reportId = DB::table('navigation')->where('name', '=', 'Report')->value('id');

        $cashPaymentsId = DB::table('navigation')->where('name', '=', 'Cash Payments')->value('id');

        $checkPaymentsId = DB::table('navigation')->where('name', '=', 'Check Payments')->value('id');

        $postingId = DB::table('navigation')->where('name', '=', 'Posting')->value('id');

        $monthlySummarySalesId = DB::table('navigation')->where('name', '=', 'Monthly Summary of Sales')->value('id');

        $unpaidInvoiceId = DB::table('navigation')->where('name', '=', 'Unpaid Invoice')->value('id');

        $birId = DB::table('navigation')->where('name', '=', 'BIR')->value('id');

        $cannedMixesId = DB::table('navigation')->where('name', '=', 'Canned & Mixes')->value('id');

        $frozenKasselId = DB::table('navigation')->where('name', '=', 'Frozen & Kassel')->value('id');

        $stockTransferId = DB::table('navigation')->where('name', '=', 'Stock Transfer')->value('id');

        $actualCountReplenishmentId = DB::table('navigation')->where('name', '=', 'Actual Count Replenishment')->value('id');

        $adjustmentReplenishmentId = DB::table('navigation')->where('name', '=', 'Adjustment Replenishment')->value('id');

        $stockAuditId = DB::table('navigation')->where('name', '=', 'Stock Audit')->value('id');

        $flexiDealId = DB::table('navigation')->where('name', '=', 'Flexi Deal')->value('id');

        $bounceCheckReportId = DB::table('navigation')->where('name', '=', 'Bounce Check Report')->value('id');

        $invoiceSeriesMappingId = DB::table('navigation')->where('name', '=', 'Invoice Series Mapping')->value('id');

        $perMaterialId = DB::table('navigation')->where('name', '=', 'Per Material')->value('id');

        $pesoValueId = DB::table('navigation')->where('name', '=', 'Peso Value')->value('id');

        $returnsPerMaterialId = DB::table('navigation')->where('name', '=', 'Returns (Per Material)')->value('id');

        $returnsPesoValueId = DB::table('navigation')->where('name', '=', 'Returns (Peso Value)')->value('id');

        $masterCustomerId = DB::table('navigation')->where('name', '=', 'Master (Customer)')->value('id');

        $masterSalesmanId = DB::table('navigation')->where('name', '=', 'Master (Salesman)')->value('id');

        $masterMaterialPriceId = DB::table('navigation')->where('name', '=', 'Master (Material Price)')->value('id');

        $summaryReversalId = DB::table('navigation')->where('name', '=', 'Summary of Reversal')->value('id');

        $summaryIncidentReportId = DB::table('navigation')->where('name', '=', 'Summary of Incident Report')->value('id');

        $userGuideId = DB::table('navigation')->where('name', '=', 'User Guide')->value('id');

        $openClosingPeriodId = DB::table('navigation')->where('name', '=', 'Open/Closing Period')->value('id');

        $dashboardId = DB::table('navigation')->where('name', '=', 'Dashboard')->value('id');

        $userManagementId = DB::table('navigation')->where('name', '=', 'User Management')->value('id');

        $userAccessMatrixId = DB::table('navigation')->where('name', '=', 'User Access Matrix')->value('id');

        $roleAccessMatrixId = DB::table('navigation')->where('name', '=', 'Role Access Matrix')->value('id');

        $actions = [
            //Sync Actions
            [
                'navigation_id' => $syncId,
                'permission'    => 'show_sync_button',
                'description'   => 'Show Sync Button'
            ],

            //User List Actions
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add New User Button'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_table',
                'description'   => 'Show User List Table'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_edit_button',
                'description'   => 'Show Edit Button'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_deactivate_button',
                'description'   => 'Show Deactivate Button'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_delete_button',
                'description'   => 'Show Delete Button'
            ],

            //Sales & Collection > Reports Actions
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_table',
                'description'   => 'Show Report Table'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_customer_code_column',
                'description'   => 'Show Customer Code Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_customer_name_column',
                'description'   => 'Show Customer Name Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_remarks_column',
                'description'   => 'Show Remarks Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_remarks_column',
                'description'   => 'Edit Remarks Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_no_column',
                'description'   => 'Show Invoice No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_invoice_no_column',
                'description'   => 'Edit Invoice No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_date_column',
                'description'   => 'Show Invoice Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_invoice_date_column',
                'description'   => 'Edit Invoice Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_gross_amount_column',
                'description'   => 'Show Invoice Gross Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_discount_amount_per_item_column',
                'description'   => 'Show Invoice Discount Amount per item Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_discount_amount_collective_column',
                'description'   => 'Show Invoice Discount Amount Collective Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_net_amount_column',
                'description'   => 'Show Invoice Net Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_cm_number_column',
                'description'   => 'Show CM Number Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_cm_number_column',
                'description'   => 'Edit CM Number Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_other_deduction_amount_column',
                'description'   => 'Show Other Deduction Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_return_slip_no_column',
                'description'   => 'Show Return Slip No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_return_slip_no_column',
                'description'   => 'Edit Return Slip No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_return_amount_column',
                'description'   => 'Show Return Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_return_discount_amount_column',
                'description'   => 'Show Return Discount Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_return_net_amount_column',
                'description'   => 'Show Return Net Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_invoice_collectible_amount_column',
                'description'   => 'Show Invoice Collectible Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_collection_date_column',
                'description'   => 'Show Collection Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_collection_date_column',
                'description'   => 'Edit Collection Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_or_number_column',
                'description'   => 'Show OR Number Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_or_number_column',
                'description'   => 'Edit OR Number Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_cash_column',
                'description'   => 'Show Cash Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_check_amount_column',
                'description'   => 'Show Check Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_bank_name_column',
                'description'   => 'Show Bank Name Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_bank_name_column',
                'description'   => 'Edit Bank Name Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_check_no_column',
                'description'   => 'Show Check No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_check_no_column',
                'description'   => 'Edit Check No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_check_date_column',
                'description'   => 'Show Check Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_check_date_column',
                'description'   => 'Edit Check Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_cm_no_column',
                'description'   => 'Show CM No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_cm_no_column',
                'description'   => 'Edit CM No. Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_cm_date_column',
                'description'   => 'Show CM Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'edit_cm_date_column',
                'description'   => 'Edit CM Date Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_cm_amount_column',
                'description'   => 'Show CM Amount Column'
            ],
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_total_collected_amount_column',
                'description'   => 'Show Total Collected Amount Column'
            ],

            //Sales & Collection > Cash Payments Actions
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_table',
                'description'   => 'Show Cash Payments Table'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'show_cash_amount_column',
                'description'   => 'Show Cash Amount Column'
            ],
            [
                'navigation_id' => $cashPaymentsId,
                'permission'    => 'edit_cash_amount_column',
                'description'   => 'Edit Cash Amount Column'
            ],

            //Sales & Collection > Check Payments Actions
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_table',
                'description'   => 'Show Check Payments Table'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'show_check_amount_column',
                'description'   => 'Show Check Amount Column'
            ],
            [
                'navigation_id' => $checkPaymentsId,
                'permission'    => 'edit_check_amount_column',
                'description'   => 'Edit Check Amount Column'
            ],

            //Sales & Collection > Posting Actions
            [
                'navigation_id' => $postingId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $postingId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $postingId,
                'permission'    => 'show_table',
                'description'   => 'Show Posting Table'
            ],
            [
                'navigation_id' => $postingId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $postingId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],

            //Sales & Collection > Monthly Summary of Sales Actions
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'show_table',
                'description'   => 'Show Posting Table'
            ],
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $monthlySummarySalesId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Posting Table Columns'
            ],

            //Unpaid Invoice Actions
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'show_table',
                'description'   => 'Show Unpaid Invoice Table'
            ],
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $unpaidInvoiceId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Unpaid Invoice Table Columns'
            ],

            //BIR Actions
            [
                'navigation_id' => $birId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $birId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $birId,
                'permission'    => 'show_table',
                'description'   => 'Show BIR Table'
            ],
            [
                'navigation_id' => $birId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $birId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $birId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort BIR Table Columns'
            ],

            //Van Inventory > Canned & Mixes Actions
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_table',
                'description'   => 'Show Canned & Mixes Table'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_transaction_date_column',
                'description'   => 'Show Transaction Date Column'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'edit_transaction_date_column',
                'description'   => 'Edit Transaction Date Column'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'show_stock_transfer_number_column',
                'description'   => 'Show Stock Transfer Number Column'
            ],
            [
                'navigation_id' => $cannedMixesId,
                'permission'    => 'edit_stock_transfer_number_column',
                'description'   => 'Edit Stock Transfer Number Column'
            ],

            //Van Inventory > Frozen & Kassel Actions
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_table',
                'description'   => 'Show Frozen & Kassel Table'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_transaction_date_column',
                'description'   => 'Show Transaction Date Column'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'edit_transaction_date_column',
                'description'   => 'Edit Transaction Date Column'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'show_stock_transfer_number_column',
                'description'   => 'Show Stock Transfer Number Column'
            ],
            [
                'navigation_id' => $frozenKasselId,
                'permission'    => 'edit_stock_transfer_number_column',
                'description'   => 'Edit Stock Transfer Number Column'
            ],

            //Van Inventory > Stock Transfer Actions
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_table',
                'description'   => 'Show Stock Transfer Table'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Stock Transfer Columns'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add Button'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_stock_transfer_number_column',
                'description'   => 'Show Stock Transfer Number Column'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'edit_stock_transfer_number_column',
                'description'   => 'Edit Stock Transfer Number Column'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_transaction_date_column',
                'description'   => 'Show Transaction Date Column'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'edit_transaction_date_column',
                'description'   => 'Edit Transaction Date Column'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'show_quantity_column',
                'description'   => 'Show Quantity Column'
            ],
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'edit_quantity_column',
                'description'   => 'Edit Quantity Column'
            ],

            //Van Inventory > Actual Count Replenishment Actions
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_table',
                'description'   => 'Show Actual Count Replenishment Table'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Actual Count Replenishment Columns'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add Button'
            ],

            //Van Inventory > Adjustment Replenishment Actions
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_table',
                'description'   => 'Show Adjustment Replenishment Table'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Adjustment Replenishment Columns'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add Button'
            ],

            //Van Inventory > Stock Audit Actions
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'show_table',
                'description'   => 'Show Stock Audit Table'
            ],
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $stockAuditId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Stock Audit Columns'
            ],

            //Van Inventory > Flexi Deal Actions
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'show_table',
                'description'   => 'Show Flexi Deal Table'
            ],
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $flexiDealId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Flexi Deal Columns'
            ],

            //Bounce Check Report Actions
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_table',
                'description'   => 'Show Bounce Check Report Table'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Bounce Check Report Table Columns'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add Button'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'show_edit_button',
                'description'   => 'Show Edit Button'
            ],

            //Invoice Series Mapping Actions
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_table',
                'description'   => 'Show Invoice Series Mapping Table'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Invoice Series Mapping Table Columns'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_add_button',
                'description'   => 'Show Add Button'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'show_edit_button',
                'description'   => 'Show Edit Button'
            ],

            //Sales Report > Per Material Actions
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_table',
                'description'   => 'Show Per Material Table'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Per Material Table Columns'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_so_no_column',
                'description'   => 'Show SO Number Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_reference_number_column',
                'description'   => 'Show Reference Number Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_activity_code_column',
                'description'   => 'Show Activity Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_customer_code_column',
                'description'   => 'Show Customer Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_customer_name_column',
                'description'   => 'Show Customer Name Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_customer_address_column',
                'description'   => 'Show Customer Address Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_remarks_column',
                'description'   => 'Show Remarks Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_remarks_column',
                'description'   => 'Edit Remarks Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_van_code_column',
                'description'   => 'Show Van Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_device_code_column',
                'description'   => 'Show Device Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_salesman_code_column',
                'description'   => 'Show Salesman Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_salesman_area_column',
                'description'   => 'Show Salesman Area Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_area_column',
                'description'   => 'Show Area Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_invoice_no_or_return_slip_no_column',
                'description'   => 'Show Invoice No./Return Slip No. Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_invoice_no_or_return_slip_no_column',
                'description'   => 'Edit Invoice No./Return Slip No. Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_invoice_date_or_return_date_column',
                'description'   => 'Show Invoice Date/Return Slip Date Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_invoice_date_or_return_date_column',
                'description'   => 'Edit Invoice Date/Return Slip Date Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_invoice_or_return_posting_date_column',
                'description'   => 'Show Invoice/Return Posting Date Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_invoice_or_return_posting_date_column',
                'description'   => 'Edit Invoice/Return Posting Date Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_segment_code_column',
                'description'   => 'Show Segment Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_item_code_column',
                'description'   => 'Show Item Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_material_description_column',
                'description'   => 'Show Material Description Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_quantity_column',
                'description'   => 'Show Quantity Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_quantity_column',
                'description'   => 'Edit Quantity Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_condition_code_column',
                'description'   => 'Show Condition Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'edit_condition_code_column',
                'description'   => 'Edit Condition Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_uom_code_column',
                'description'   => 'Show Uom Code Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_taxable_amount_column',
                'description'   => 'Show Taxable Amount Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_vat_amount_column',
                'description'   => 'Show VAT Amount Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_discount_rate_per_item_column',
                'description'   => 'Show Discount Rate per item Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_discount_amount_per_item_column',
                'description'   => 'Show Discount Amount per item Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_collective_discount_rate_column',
                'description'   => 'Show Collective Discount Rate Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_collective_discount_amount_column',
                'description'   => 'Show Collective Discount Amount Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_reference_no_column',
                'description'   => 'Show Reference No. Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_remarks_column',
                'description'   => 'Show Remarks Column'
            ],
            [
                'navigation_id' => $perMaterialId,
                'permission'    => 'show_total_sales_column',
                'description'   => 'Show Total Sales Column'
            ],

            //Sales Report > Peso Value Actions
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_table',
                'description'   => 'Show Peso Value Table'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Per Material Table Columns'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_so_no_column',
                'description'   => 'Show SO Number Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_reference_number_column',
                'description'   => 'Show Reference Number Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_activity_code_column',
                'description'   => 'Show Activity Code Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_customer_code_column',
                'description'   => 'Show Customer Code Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_customer_name_column',
                'description'   => 'Show Customer Name Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_customer_address_column',
                'description'   => 'Show Customer Address Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_remarks_column',
                'description'   => 'Show Remarks Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'edit_remarks_column',
                'description'   => 'Edit Remarks Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_van_code_column',
                'description'   => 'Show Van Code Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_device_code_column',
                'description'   => 'Show Device Code Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_salesman_code_column',
                'description'   => 'Show Salesman Code Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_salesman_name_column',
                'description'   => 'Show Salesman Name Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_area_column',
                'description'   => 'Show Area Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_invoice_no_or_return_slip_no_column',
                'description'   => 'Show Invoice No./Return Slip No. Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'edit_invoice_no_or_return_slip_no_column',
                'description'   => 'Edit Invoice No./Return Slip No. Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_invoice_date_or_return_date_column',
                'description'   => 'Show Invoice Date/Return Slip Date Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'edit_invoice_date_or_return_date_column',
                'description'   => 'Edit Invoice Date/Return Slip Date Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_invoice_or_return_posting_date_column',
                'description'   => 'Show Invoice/Return Posting Date Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'edit_invoice_or_return_posting_date_column',
                'description'   => 'Edit Invoice/Return Posting Date Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_taxable_amount_column',
                'description'   => 'Show Taxable Amount Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_vat_amount_column',
                'description'   => 'Show VAT Amount Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_discount_rate_per_item_column',
                'description'   => 'Show Discount Rate per item Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_discount_amount_per_item_column',
                'description'   => 'Show Discount Amount per item Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_collective_discount_rate_column',
                'description'   => 'Show Collective Discount Rate Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_collective_discount_amount_column',
                'description'   => 'Show Collective Discount Amount Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_reference_no_column',
                'description'   => 'Show Reference No. Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_remarks_column',
                'description'   => 'Show Remarks Column'
            ],
            [
                'navigation_id' => $pesoValueId,
                'permission'    => 'show_total_sales_column',
                'description'   => 'Show Total Sales Column'
            ],

            //Sales Report > Returns (Per Material) Actions
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'show_table',
                'description'   => 'Show Returns (Per Material) Table'
            ],
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $returnsPerMaterialId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Returns (Per Material) Table Columns'
            ],

            //Sales Report > Returns (Peso Value) Actions
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'show_table',
                'description'   => 'Show Returns (Peso Value) Table'
            ],
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $returnsPesoValueId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Returns (Peso Value) Table Columns'
            ],

            //Sales Report > Master (Customer) Actions
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'show_table',
                'description'   => 'Show Master (Customer) Table'
            ],
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $masterCustomerId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Master (Customer) Table Columns'
            ],

            //Sales Report > Master (Salesman) Actions
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'show_table',
                'description'   => 'Show Master (Salesman) Table'
            ],
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $masterSalesmanId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Master (Salesman) Table Columns'
            ],

            //Sales Report > Master (Material Price) Actions
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'show_table',
                'description'   => 'Show Master (Material Price) Table'
            ],
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $masterMaterialPriceId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Master (Material Price) Table Columns'
            ],

            //Summary of Reversal Actions
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'show_table',
                'description'   => 'Show Summary of Reversal Table'
            ],
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $summaryReversalId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Summary of Reversal Table Columns'
            ],

            //Summary of Incident Report Actions
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'show_search_field',
                'description'   => 'Show Search Field'
            ],
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'show_table',
                'description'   => 'Show Summary of Incident Report Table'
            ],
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'show_print',
                'description'   => 'Show Print'
            ],
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'show_download',
                'description'   => 'Show Download'
            ],
            [
                'navigation_id' => $summaryIncidentReportId,
                'permission'    => 'can_sort_columns',
                'description'   => 'Sort Summary of Incident Report Table Columns'
            ],

            //User Guide Actions
            [
                'navigation_id' => $userGuideId,
                'permission'    => 'show_table',
                'description'   => 'Show User Guide Table'
            ],
            [
                'navigation_id' => $userGuideId,
                'permission'    => 'show_download_button',
                'description'   => 'Show Download Button'
            ],
            [
                'navigation_id' => $userGuideId,
                'permission'    => 'show_upload_button',
                'description'   => 'Show Upload Button'
            ],

            //Open/Closing Period Actions
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'show_filter',
                'description'   => 'Show Filter'
            ],
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'show_table',
                'description'   => 'Show User Guide Table'
            ],
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'show_print_button',
                'description'   => 'Show Print Button'
            ],
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'can_check_uncheck_period_date',
                'description'   => 'Can Check/Uncheck Period Date'
            ],
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'can_close_period',
                'description'   => 'Can Close Period'
            ],
            [
                'navigation_id' => $openClosingPeriodId,
                'permission'    => 'can_open_period',
                'description'   => 'Can Open Period'
            ],

            //Dashboard Actions
            [
                'navigation_id' => $dashboardId,
                'permission'    => 'show_sales_and_collection_count',
                'description'   => 'Show Sales & Collection Count'
            ],
            [
                'navigation_id' => $dashboardId,
                'permission'    => 'show_van_inventory_count',
                'description'   => 'Show Van Inventory Count'
            ],
            [
                'navigation_id' => $dashboardId,
                'permission'    => 'show_unpaid_invoice_count',
                'description'   => 'Show Unpaid Invoice Count'
            ],
            [
                'navigation_id' => $dashboardId,
                'permission'    => 'show_sales_report_count',
                'description'   => 'Show Sales Report Count'
            ],
            [
                'navigation_id' => $dashboardId,
                'permission'    => 'show_bir_count',
                'description'   => 'Show BIR Count'
            ],

            //User Access Matrix Actions,
            [
                'navigation_id' => $userAccessMatrixId,
                'permission'    => 'show_save_button',
                'description'   => 'Show Save Button'
            ],
            [
                'navigation_id' => $roleAccessMatrixId,
                'permission'    => 'can_edit_role_permission',
                'description'   => 'Can Edit Role Permission'
            ],
            [
                'navigation_id' => $userAccessMatrixId,
                'permission'    => 'can_edit_user_role_permission',
                'description'   => 'Can Edit User Role Permission'
            ],
            [
                'navigation_id' => $userAccessMatrixId,
                'permission'    => 'can_view_permission',
                'description'   => 'Can View Permission'
            ],

            // Additional Sales & Collection > Reports Actions
            [
                'navigation_id' => $reportId,
                'permission'    => 'show_customer_address_column',
                'description'   => 'Show Customer Address Column'
            ],

            // Additional Van Inventory > Stock Transfer Actions
            [
                'navigation_id' => $stockTransferId,
                'permission'    => 'can_save',
                'description'   => 'Create Stock Transfer'
            ],

            // Additional Van Inventory > Actual Count Replenishment Actions
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'can_save',
                'description'   => 'Create Actual Count Replenishment'
            ],
            [
                'navigation_id' => $actualCountReplenishmentId,
                'permission'    => 'can_delete',
                'description'   => 'Delete Actual Count Replenishment'
            ],

            // Additional Van Inventory > Adjustment Replenishment Actions
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'can_save',
                'description'   => 'Create Adjustment Replenishment'
            ],
            [
                'navigation_id' => $adjustmentReplenishmentId,
                'permission'    => 'can_delete',
                'description'   => 'Delete Adjustment Replenishment'
            ],

            // Additional Bounce Check Report Actions
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'can_save',
                'description'   => 'Create Bounce Check'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'can_update',
                'description'   => 'Update Bounce Check'
            ],
            [
                'navigation_id' => $bounceCheckReportId,
                'permission'    => 'can_delete',
                'description'   => 'Delete Bounce Check'
            ],

            // Additional Invoice Series Mapping Actions
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'can_save',
                'description'   => 'Create Invoice Series Mapping'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'can_update',
                'description'   => 'Update Invoice Series Mapping'
            ],
            [
                'navigation_id' => $invoiceSeriesMappingId,
                'permission'    => 'can_delete',
                'description'   => 'Delete Invoice Series Mapping'
            ],

            //Additional User List Actions
            [
                'navigation_id' => $userListId,
                'permission'    => 'show_activate_button',
                'description'   => 'Show Activate Button'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'can_save',
                'description'   => 'Create User Profile'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'can_update',
                'description'   => 'Update User Profile'
            ],
            [
                'navigation_id' => $userListId,
                'permission'    => 'can_delete',
                'description'   => 'Delete User Profile'
            ],

            // User Management Actions
            [
                'navigation_id' => $userManagementId,
                'permission'    => 'can_save_profile',
                'description'   => 'Save My Profile'
            ],
            [
                'navigation_id' => $userManagementId,
                'permission'    => 'read_only_profile',
                'description'   => 'Read Only My Profile'
            ],
            [
                'navigation_id' => $userManagementId,
                'permission'    => 'can_change_password',
                'description'   => 'Save New Password'
            ],

            //Role Access Matrix Actions,
            [
                'navigation_id' => $roleAccessMatrixId,
                'permission'    => 'show_save_button',
                'description'   => 'Show Save Button'
            ],
            [
                'navigation_id' => $roleAccessMatrixId,
                'permission'    => 'can_view_permission',
                'description'   => 'Can View Permission'
            ],
        ];

        foreach ($actions as $action) {
            NavigationPermission::create($action);
        }
    }
}
