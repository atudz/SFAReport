<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppReturnReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_return_reason', function(Blueprint $table) {
			$table->string('reason_code', 20);
			$table->string('description', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
			$table->primary('reason_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_return_reason');
    }
}
