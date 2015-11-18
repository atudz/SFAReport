<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_invoice', function(Blueprint $table) {
        	$table->integer('invoice_id');
			$table->string('invoice_number', 20);
			$table->string('salesman_code', 20)->index();
			$table->string('customer_code', 20)->index();
			$table->string('ship_to_code', 20)->index();
			$table->decimal('original_amount');
			$table->decimal('balance_amount');
			$table->dateTime('invoice_date');
			$table->dateTime('invoice_due_date')->nullable();
			$table->string('document_type', 2);
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('invoice_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_invoice');
    }
}
