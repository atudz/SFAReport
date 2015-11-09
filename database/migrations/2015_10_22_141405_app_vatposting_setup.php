<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppVatpostingSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_vatposting_setup', function(Blueprint $table) {
			$table->string('vatposting_code', 20);
			$table->string('vatposting_name', 50);
			$table->decimal('vatposting_rate');
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
			$table->primary('vatposting_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_vatposting_setup');
    }
}
