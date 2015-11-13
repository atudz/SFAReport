<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnSalesOrderHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_sales_order_header', function(Blueprint $table) {
			$table->string('so_number', 20)->index();
			$table->string('reference_num', 50)->index();
			$table->string('salesman_code', 20)->index();
			$table->string('customer_code', 20)->index();
			$table->string('ship_to_code', 20)->index();
			$table->string('van_code', 20)->index();
			$table->dateTime('so_date');
			$table->string('po_number', 20)->nullable();
			$table->string('invoice_number', 20)->nullable();
			$table->string('dr_number', 20)->nullable();
			$table->string('status', 2)->default('P');
			$table->string('served_status', 2);
			$table->primary('so_number');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			//$table->unique(['so_number','reference_num','invoice_number']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_sales_order_header');
    }
}
