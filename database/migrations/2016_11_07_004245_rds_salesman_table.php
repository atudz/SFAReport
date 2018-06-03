<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RdsSalesmanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('rds_salesman', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('area_name')->nullable()->index();
    		$table->string('area_code')->nullable()->index();
    		$table->string('salesman_name');
    		$table->string('salesman_code')->index();
    		$table->string('jr_salesman_name')->nullable();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('rds_salesman');
    }
}
