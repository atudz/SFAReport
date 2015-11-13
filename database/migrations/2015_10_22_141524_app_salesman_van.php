<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppSalesmanVan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_salesman_van', function(Blueprint $table) {
			$table->string('salesman_code', 20)->index();
			$table->string('van_code', 20)->index();
			$table->string('status', 2);
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			//$table->unique(['salesman_code','van_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_salesman_van');
    }
}
