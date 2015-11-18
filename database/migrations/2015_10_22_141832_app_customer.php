<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_customer', function(Blueprint $table) {
        	$table->integer('customer_id');
			$table->string('customer_code', 20);
			$table->string('area_code', 30)->index();
			$table->string('customer_name', 100);
			$table->string('customer_name2', 50)->nullable();
			$table->string('storetype_code', 20)->index();
			$table->string('vatposting_code', 20)->index();
			$table->string('vat_ex_flag', 2);
			$table->string('address_1', 75);
			$table->string('address_2', 75)->nullable();
			$table->string('address_3', 75)->nullable();
			$table->string('contact_name', 50);
			$table->string('contact_num', 30);
			$table->decimal('credit_limit');
			// To question
			$table->string('discount_group_code', 20)->index();
			$table->string('warehouse_code', 20)->nullable();
			
			$table->tinyInteger('signature_flag');
			$table->string('ship_to_code', 20)->index();
			$table->string('customer_price_group', 50);
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('payment_mode', 10)->nullable();
			$table->string('so_type', 2)->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('customer_id');
			//$table->unique('customer_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_customer');
    }
}
