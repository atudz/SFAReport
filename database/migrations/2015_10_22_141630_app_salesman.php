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
        	$table->integer('salesman_id');
			$table->string('salesman_code', 20);
			$table->string('salesman_name', 50);
			$table->string('status', 2);
			$table->string('password',120)->nullable();
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->dateTime('last_registered_date')->nullable();
			$table->string('salesman_email', 50)->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('salesman_id');
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
