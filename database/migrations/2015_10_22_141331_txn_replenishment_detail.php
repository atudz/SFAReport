<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnReplenishmentDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_replenishment_detail', function(Blueprint $table) {
        	$table->integer('replenishment_detail_id');
			$table->string('reference_number', 20)->index();
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('quantity');
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('status', 2);
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('replenishment_detail_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_replenishment_detail');
    }
}
