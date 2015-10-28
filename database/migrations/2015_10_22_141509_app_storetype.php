<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppStoretype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_storetype', function(Blueprint $table) {
			$table->string('storetype_code', 20);
			$table->string('storetype_name', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('storetype_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_storetype');
    }
}
