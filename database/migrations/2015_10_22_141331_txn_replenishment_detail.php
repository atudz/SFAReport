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
			$table->string('reference_number', 20)->index();
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('quantity');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			//$table->unique(['reference_number','item_code','uom_code']);
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
