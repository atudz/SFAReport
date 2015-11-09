<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppSalesman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_salesman', function(Blueprint $table) {
			$table->string('salesman_code', 20);
			$table->string('salesman_name', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
			$table->primary('salesman_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_salesman');
    }
}
