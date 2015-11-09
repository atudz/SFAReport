<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppDiscountGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_discount_group', function(Blueprint $table) {
			$table->string('discount_group_code', 20);
			$table->decimal('discount');
			$table->string('status', 2);
			$table->dateTime('modified_at')->nullable();
			$table->integer('modified_by')->index()->default('0');
			$table->primary('discount_group_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_discount_group');
    }
}
