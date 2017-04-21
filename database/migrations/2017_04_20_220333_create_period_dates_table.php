<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('period_id')->index();
            $table->timestamps();
            $table->tinyInteger('period_date');
            $table->enum('period_date_status', ['open', 'close']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('period_dates');
    }
}
