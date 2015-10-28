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
			$table->string('customer_code', 20);
			$table->string('area_code', 30)->index();
			$table->string('customer_name', 100);
			$table->string('customer_name2', 50)->nullable();
			$table->string('store_type_code', 100)->index();
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
			
			$table->string('ship_to_code', 20)->index();
			$table->string('customer_price_group', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('customer_code');
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
