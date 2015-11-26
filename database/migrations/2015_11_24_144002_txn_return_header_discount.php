<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnReturnHeaderDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_return_header_discount', function(Blueprint $table) {
        	$table->string('reference_num', 50)->index();
			$table->string('deduction_type_code', 20)->index();
			$table->string('deduction_code', 20)->index();
			$table->decimal('deduction_rate',5,2);
			$table->decimal('deduction_amount');
			$table->dateTime('ref_date')->nullable();
			$table->string('ref_no', 20)->nullable();
			$table->string('remarks',100)->nullable();
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
		});
    	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_return_header_discount');
    }
}
