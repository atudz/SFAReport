<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phone', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('phone_number', 255)->nullable();
			$table->integer('user_id')->index()->default('0');
			$table->enum('type', [0,1,2]);
			$table->tinyInteger('is_mobile')->default('0');
			$table->tinyInteger('primary')->default('0');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_phone');
    }
}
