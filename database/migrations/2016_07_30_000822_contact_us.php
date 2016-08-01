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
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->string('email');
            $table->string('phone');
            $table->string('telephone');
            $table->string('telephone');
            $table->string('location_assignment_code', 255);
            $table->time('time_from');
            $table->time('time_to');
            $table->string('subject');
            $table->text('comment');
            $table->string('action');
            $table->string('status');
            $table->foreign('user_id')->references('id')->on('user')
                ->onCascade('Delete')->onCascade('Update');
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
