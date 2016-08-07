<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactUs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->timestamps();
            $table->string('email');
            $table->string('mobile');
            $table->string('telephone');
            $table->string('location_assignment_code');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('subject');
            $table->text('message');
            $table->string('action');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_us');
    }
}
