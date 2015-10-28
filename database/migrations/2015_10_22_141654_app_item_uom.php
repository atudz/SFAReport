<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppItemUom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_item_uom', function(Blueprint $table) {
			$table->string('uom_code', 20);
			$table->string('description', 50);
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->primary('uom_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_item_uom');
    }
}
