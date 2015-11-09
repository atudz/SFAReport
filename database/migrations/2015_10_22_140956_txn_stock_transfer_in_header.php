<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnStockTransferInHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_stock_transfer_in_header', function(Blueprint $table) {
			$table->string('stock_transfer_number', 20)->index();
			$table->string('salesman_code', 20)->index();
			$table->string('dest_van_code', 20)->index();
			$table->string('src_van_code', 20)->index();
			$table->dateTime('transfer_date');
			$table->string('status', 2)->default('P');
			$table->primary('stock_transfer_number');
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_stock_transfer_in_header');
    }
}
