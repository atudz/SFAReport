<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnReplenishmentHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_replenishment_header', function(Blueprint $table) {
			$table->string('reference_number', 20);
			$table->string('van_code', 20);
			$table->dateTime('replenishment_date');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('reference_number');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_replenishment_header');
    }
}
