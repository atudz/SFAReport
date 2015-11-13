<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnCollectionHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_collection_header', function(Blueprint $table) {
			$table->string('collection_num', 20);
			$table->string('or_number', 20);
			$table->string('reference_num', 50)->index();
			$table->string('salesman_code', 20);
			$table->string('customer_code', 20);
			$table->string('ship_to_code', 20);
			$table->dateTime('or_date');
			$table->decimal('or_amount');
			$table->decimal('applied_amount');
			$table->string('status', 2);
			$table->tinyInteger('remitted');
			$table->string('remit_reference_num', 50)->index();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary(['collection_num','or_number']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_collection_header');
    }
}
