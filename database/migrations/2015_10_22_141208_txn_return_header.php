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
    		$table->string('return_txn_number', 20);
    		$table->string('reference_num', 50)->index();
    		$table->string('customer_code', 20)->index();
    		$table->string('ship_to_code', 20)->index();
    		$table->string('van_code', 20)->index();
    		$table->string('salesman_code', 20)->index();
    		$table->dateTime('return_date'); 
    		$table->string('return_slip_num', 20)->index();
    		$table->string('status', 2)->default('P');
    		$table->dateTime('updated_at')->nullable();
    		$table->integer('updated_by')->index()->default('0');
    		$table->primary('return_txn_number');
    		//$table->unique(['return_txn_number','return_slip_num']);
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
