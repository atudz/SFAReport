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
        	$table->integer('item_master_id');
			$table->string('item_code', 20)->index();
			$table->string('description', 50);
			$table->string('description2', 50)->nullable();
			$table->string('segment_code', 20)->index();
			$table->string('brand_code', 20)->index();
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('item_master_id');
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
