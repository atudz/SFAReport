<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppItemPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_item_price', function(Blueprint $table) {
			$table->string('item_code', 20)->index();
			$table->string('customer_price_group', 50)->index();
			$table->string('uom_code', 20)->index();
			$table->decimal('unit_price');
			$table->dateTime('effective_date_from');
			$table->dateTime('effective_date_to');
			$table->string('status', 2);
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			//$table->unique(['item_code','customer_price_group','uom_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_item_price');
    }
}
