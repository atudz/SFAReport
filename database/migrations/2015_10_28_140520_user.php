<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_group_id')->index()->default('0');
			$table->string('firstname', 255);
			$table->string('lastname', 255);
			$table->string('middlename', 255)->nullable();
			$table->string('password', 255);
			$table->string('email', 255)->unique()->nullable();
			$table->integer('age')->index()->nullable();
			$table->enum('gender', array('0', '1', '2'))->default('0');
			$table->string('address1', 1000)->nullable();
			$table->string('address2', 1000)->nullable();
			$table->string('address3', 1000)->nullable();
			$table->datetime('last_login_date')->nullable();
			$table->integer('created_by')->index()->default('0');
			$table->string('avatar', 255)->nullable();
			$table->rememberToken();
			$table->softDeletes();			
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
