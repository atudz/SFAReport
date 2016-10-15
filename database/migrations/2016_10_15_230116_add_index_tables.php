<?php

use Illuminate\Database\Migrations\Migration;

class AddIndexTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	\DB::statement('ALTER TABLE `app_area` ADD INDEX `area_code` (`area_code`)');
    	\DB::statement('ALTER TABLE `app_area` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_customer` ADD INDEX `customer_code` (`customer_code`)');
    	\DB::statement('ALTER TABLE `app_customer` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_discount_group` ADD INDEX `discount_group_code` (`discount_group_code`)');
    	\DB::statement('ALTER TABLE `app_discount_group` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_item_brand` ADD INDEX `brand_code` (`brand_code`)');
    	\DB::statement('ALTER TABLE `app_item_brand` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `app_item_master` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_item_master_uom` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_item_price` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_item_segment` ADD INDEX `segment_code` (`segment_code`)');
    	\DB::statement('ALTER TABLE `app_item_segment` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_item_uom` ADD INDEX `uom_code` (`uom_code`)');
    	\DB::statement('ALTER TABLE `app_item_uom` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_return_reason` ADD INDEX `reason_code` (`reason_code`)');
    	\DB::statement('ALTER TABLE `app_return_reason` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_salesman` ADD INDEX `salesman_code` (`salesman_code`)');
    	\DB::statement('ALTER TABLE `app_salesman` ADD INDEX `salesman_email` (`salesman_email`)');
    	\DB::statement('ALTER TABLE `app_salesman` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `app_salesman_customer` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_salesman_van` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_storetype` ADD INDEX `segment_code` (`storetype_code`)');
    	\DB::statement('ALTER TABLE `app_storetype` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_van` ADD INDEX `van_code` (`van_code`)');
    	\DB::statement('ALTER TABLE `app_van` ADD INDEX `van_type` (`van_type`)');
    	\DB::statement('ALTER TABLE `app_van` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `app_vatposting_setup` ADD INDEX `vatposting_code` (`vatposting_code`)');    	
    	\DB::statement('ALTER TABLE `app_vatposting_setup` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_activity_salesman` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_collection_detail` ADD INDEX `cm_number` (`cm_number`)');
    	\DB::statement('ALTER TABLE `txn_collection_detail` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `collection_num` (`collection_num`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `or_number` (`or_number`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `salesman_code` (`salesman_code`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `customer_code` (`customer_code`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `ship_to_code` (`ship_to_code`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `or_date` (`or_date`)');
    	\DB::statement('ALTER TABLE `txn_collection_header` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_collection_invoice` ADD INDEX `or_number` (`or_number`)');
    	\DB::statement('ALTER TABLE `txn_collection_invoice` ADD INDEX `invoice_number` (`invoice_number`)');
    	\DB::statement('ALTER TABLE `txn_collection_invoice` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_evaluated_objective` ADD INDEX `status` (`status`)');
    	
    	
    	\DB::statement('ALTER TABLE `txn_invoice` ADD INDEX `invoice_number` (`invoice_number`)');
    	\DB::statement('ALTER TABLE `txn_invoice` ADD INDEX `invoice_date` (`invoice_date`)');
    	\DB::statement('ALTER TABLE `txn_invoice` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `txn_replenishment_detail` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_replenishment_header` ADD INDEX `reference_number` (`reference_number`)');
    	\DB::statement('ALTER TABLE `txn_replenishment_header` ADD INDEX `van_code` (`van_code`)');
    	\DB::statement('ALTER TABLE `txn_replenishment_header` ADD INDEX `replenishment_date` (`replenishment_date`)');
    	\DB::statement('ALTER TABLE `txn_replenishment_header` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_return_detail` ADD INDEX `return_txn_number` (`return_txn_number`)');
    	\DB::statement('ALTER TABLE `txn_return_detail` ADD INDEX `condition_code` (`condition_code`)');
    	\DB::statement('ALTER TABLE `txn_return_detail` ADD INDEX `item_status` (`item_status`)');
    	\DB::statement('ALTER TABLE `txn_return_detail` ADD INDEX `status` (`status`)');
    	
    	
    	\DB::statement('ALTER TABLE `txn_return_header` ADD INDEX `return_txn_number` (`return_txn_number`)');    	
    	\DB::statement('ALTER TABLE `txn_return_header` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `txn_return_header_discount` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `txn_sales_order_deal` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_sales_order_detail` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_sales_order_detail_discount` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_sales_order_header` ADD INDEX `so_date` (`so_date`)');
    	\DB::statement('ALTER TABLE `txn_sales_order_header` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_sales_order_header_discount` ADD INDEX `status` (`status`)');
    	    	
    	\DB::statement('ALTER TABLE `txn_stock_transfer_in_detail` ADD INDEX `status` (`status`)');
    	
    	\DB::statement('ALTER TABLE `txn_stock_transfer_in_header` ADD INDEX `transfer_date` (`transfer_date`)');
    	\DB::statement('ALTER TABLE `txn_stock_transfer_in_header` ADD INDEX `status` (`status`)');
    	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
