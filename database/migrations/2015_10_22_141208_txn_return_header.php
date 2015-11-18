<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnReturnHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('txn_return_header', function(Blueprint $table) {
    		$table->integer('return_header_id');
    		$table->string('return_txn_number', 20);
    		$table->string('reference_num', 50)->index();
    		$table->string('customer_code', 20)->index();
    		$table->string('ship_to_code', 20)->index();
    		$table->string('van_code', 20)->index();
    		$table->string('salesman_code', 20)->index();
    		$table->dateTime('return_date'); 
    		$table->string('return_slip_num', 20)->index();
    		$table->string('status', 2)->default('P');
    		$table->string('modified_by', 50)->index();
    		$table->dateTime('modified_date')->nullable();
    		$table->dateTime('sfa_modified_date')->nullable();
    		$table->string('device_code', 20)->nullable();
    		$table->dateTime('updated_at')->nullable();
    		$table->integer('updated_by')->index()->default('0');
    		$table->primary('return_header_id');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_return_header');
    }
}
