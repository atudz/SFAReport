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
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
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
