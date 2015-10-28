<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnSalesOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_sales_order_detail', function(Blueprint $table) {
			$table->string('so_number', 20)->index();
			$table->string('reference_num', 50)->index();
			$table->string('item_code', 20)->index();
			$table->decimal('vat_amount');
			$table->decimal('discount_amount');
			$table->decimal('gross_order_amount');
			$table->decimal('gross_served_amount');
			$table->string('uom_code', 20)->index();
			$table->integer('order_qty');
			$table->integer('served_qty');
			$table->integer('onhand_qty');
			$table->string('status', 2)->default('P');
			$table->string('remarks', 160)->nullable();
			$table->decimal('discount_rate')->nullable();
			$table->dateTime('modified_at')->nullable();
			//$table->unique(['so_number','reference_num','item_code','uom_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_sales_order_detail');
    }
}
