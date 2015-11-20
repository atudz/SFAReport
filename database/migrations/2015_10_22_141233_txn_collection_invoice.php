<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnCollectionInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_collection_invoice', function(Blueprint $table) {
        	$table->integer('collection_invoice_id');
			$table->string('collection_invoice_num', 20);
			$table->string('reference_num', 20)->index();
			$table->string('collection_num', 20)->index();
			$table->string('or_number', 20);
			$table->string('invoice_number', 20);
			$table->decimal('applied_amount');
			$table->decimal('balance_amount')->nullable();
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('device_code', 20)->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('collection_invoice_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_collection_invoice');
    }
}
