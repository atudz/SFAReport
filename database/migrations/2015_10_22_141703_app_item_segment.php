<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppItemSegment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_item_segment', function(Blueprint $table) {
			$table->string('segment_code', 20);
			$table->string('description', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('segment_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_item_segment');
    }
}
