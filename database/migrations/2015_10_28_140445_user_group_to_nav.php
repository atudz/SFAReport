<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserGroupToNav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_to_nav', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_group_id')->index()->default('0');
			$table->integer('navigation_id')->index()->default('0');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_group_to_nav');
    }
}
