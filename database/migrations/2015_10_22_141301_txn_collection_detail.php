<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnCollectionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_collection_detail', function(Blueprint $table) {
        	$table->integer('collection_detail_id');
			$table->string('collection_num', 20)->index();
			$table->string('reference_num', 50)->index();
			$table->string('or_number', 20)->index();
			$table->integer('payment_sequence_num');
			$table->string('payment_method_code', 20);
			$table->decimal('payment_amount');
			$table->string('check_number', 20)->nullable();
			$table->dateTime('check_date')->nullable();
			$table->string('bank', 50)->nullable();
			$table->string('cm_number', 20)->nullable();
			$table->string('status', 2)->default('P');
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('device_code', 20)->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('collection_detail_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_collection_detail');
    }
}
