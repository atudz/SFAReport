<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnStockTransferInDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_stock_transfer_in_detail', function(Blueprint $table) {
        	$table->integer('stock_transfer_in_detail_id');
			$table->string('stock_transfer_number', 20)->index();
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('quantity');
			$table->string('status', 2)->default('P');
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('device_code', 20)->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('stock_transfer_in_detail_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_stock_transfer_in_detail');
    }
}
