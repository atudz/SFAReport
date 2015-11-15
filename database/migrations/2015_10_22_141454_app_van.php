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
        	$table->integer('van_id');
			$table->string('van_code', 20);
			$table->tinyInteger('van_type');
			$table->string('description', 100);
			$table->decimal('load_limi_amount');
			$table->string('status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->bigInteger('version');
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('van_id');
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
