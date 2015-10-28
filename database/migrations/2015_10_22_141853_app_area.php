<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_area', function(Blueprint $table) {
			$table->string('area_code', 20);
			$table->string('area_name', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('area_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_area');
    }
}
