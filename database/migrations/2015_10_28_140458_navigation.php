<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Navigation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255)->nullable();
            $table->string('url', 255)->nullable();
			$table->string('class', 255)->nullable();
			$table->unsignedInteger('parent_id')->index()->default(0);
			$table->unsignedTinyInteger('active')->default(1);
			$table->unsignedInteger('order')->default(0);
			$table->unsignedTinyInteger('summary')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navigation');
    }
}
