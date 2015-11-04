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
			$table->string('collection_invoice_num', 20);
			$table->string('reference_num', 20)->index();
			$table->string('collection_num', 20)->index();
			$table->string('or_number', 20);
			$table->string('invoice_number', 20);
			$table->decimal('applied_amount');
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			//$table->primary('collection_invoice_num');
			//$table->unique(['collection_invoice_num','reference_num','collection_num']);
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
