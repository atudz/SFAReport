<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppItemMasterUom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_item_master_uom', function(Blueprint $table) {
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('unit_conversion');
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			//$table->unique(['item_code','uom_code']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_item_master_uom');
    }
}
