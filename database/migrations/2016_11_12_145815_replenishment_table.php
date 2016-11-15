<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplenishmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('replenishment', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('reference_num')->index();
    		$table->string('counted')->nullable();
    		$table->string('confirmed')->nullable();
    		$table->string('last_sr')->nullable();
    		$table->string('last_rprr')->nullable();
    		$table->string('last_cs')->nullable();
    		$table->string('last_dr')->nullable();
    		$table->string('last_ddr')->nullable();
    		$table->text('remarks')->nullable();
    		$table->softDeletes();    		
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('replenishment');
    }
}
