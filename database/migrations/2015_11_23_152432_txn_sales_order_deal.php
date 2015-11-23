<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnSalesOrderDeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_sales_order_deal', function(Blueprint $table) {
        	$table->integer('so_detail_deal_id');
			$table->string('reference_num', 50)->index();
			$table->string('deal_code', 90)->index();
			$table->string('deal_description', 100)->index();
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('deal_order_qty');
			$table->integer('deal_served_qty');
			$table->integer('regular_order_qty');
			$table->integer('regular_served_qty');
			$table->string('trade_item_code', 20)->index();
			$table->string('trade_item_uom', 20)->index();
			$table->integer('trade_order_qty');
			$table->integer('trade_served_qty');
			$table->decimal('vat_order_amount');
			$table->decimal('vat_served_amount');
			$table->decimal('gross_order_amount');
			$table->decimal('gross_served_amount');
			$table->string('remarks', 160)->nullable();
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('so_detail_deal_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_sales_order_deal');
    }
}
