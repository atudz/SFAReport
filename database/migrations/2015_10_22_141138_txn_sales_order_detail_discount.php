<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnSalesOrderDetailDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_sales_order_detail_discount', function(Blueprint $table) {
			$table->string('reference_num', 50)->index();
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->decimal('discount_rate');
			$table->decimal('gross_order_amount');
			$table->decimal('gross_served_amount');
			$table->decimal('discount_order_amount');
			$table->decimal('discount_served_amount');
			$table->string('status', 2)->default('P');
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
			//$table->unique(['reference_num','item_code','uom_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_sales_order_detail_discount');
    }
}
