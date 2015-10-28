<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppItemMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_item_master', function(Blueprint $table) {
			$table->string('item_code', 20)->index();
			$table->string('description', 50);
			$table->string('description2', 50)->nullable();
			$table->string('segment_code', 20)->index();
			$table->string('brand_code', 20)->index();
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			//$table->unique(['item_code','segment_code','brand_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_item_master');
    }
}
