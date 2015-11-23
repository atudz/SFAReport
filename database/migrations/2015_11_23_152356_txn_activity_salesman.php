<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnActivitySalesman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_activity_salesman', function(Blueprint $table) {
        	$table->integer('activity_header_id');
			$table->string('reference_num', 50)->index();
			$table->string('activity_code', 50)->index();
			$table->string('salesman_code', 20)->index();
			$table->string('customer_code', 20)->index();
			$table->string('ship_to_code', 20)->index();
			$table->dateTime('start_datetime');
			$table->dateTime('end_datetime');
			$table->string('call_planned', 2)->nullable();
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('device_code', 20)->nullable();
			$table->text('latitude')->nullable();
			$table->text('longitude')->nullable();
			$table->text('location')->nullable();
			$table->decimal('vat_rate',5,2)->nullable();
			$table->string('vat_ex_flag', 2)->nullable();
			$table->string('vat_after_discount_flag', 1)->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('activity_header_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_activity_salesman');
    }
}
