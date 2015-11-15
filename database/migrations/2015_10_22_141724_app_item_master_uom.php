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
        	$table->integer('item_master_uom_id');
			$table->string('item_code', 20)->index();
			$table->string('uom_code', 20)->index();
			$table->integer('unit_conversion');
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('item_master_uom_id');
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
