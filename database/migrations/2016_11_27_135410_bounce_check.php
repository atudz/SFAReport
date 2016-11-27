<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BounceCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('bounce_check', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('txn_number')->index();
    		$table->string('salesman_code')->index();
    		$table->string('jr_salesman_id')->index();
    		$table->string('area_code')->index();
    		$table->string('customer_code')->index();
    		$table->string('dm_number')->index()->nullable();
    		$table->dateTime('dm_date')->index()->nullable();
    		$table->string('invoice_number')->index()->nullable();
    		$table->dateTime('invoice_date')->index()->nullable();
    		$table->string('bank_name')->nullable();
    		$table->string('account_number')->index()->nullable();
    		$table->string('cheque_number')->index()->nullable();
    		$table->dateTime('cheque_date')->index()->nullable();
    		$table->string('reason')->nullable();
    		$table->decimal('original_amount')->default(0.00);
    		$table->decimal('payment_amount')->default(0.00);
    		$table->dateTime('payment_date')->index()->nullable();
    		$table->decimal('balance_amount')->default(0.00);    		
    		$table->text('remarks')->nullable();
    		$table->text('delete_remarks')->nullable();
    		$table->softDeletes();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('bounce_check');
    }
}
