<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppVan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_van', function(Blueprint $table) {
			$table->string('van_code', 20);
			$table->tinyInteger('van_type');
			$table->string('description', 100);
			$table->decimal('load_limi_amount');
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('van_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_van');
    }
}
