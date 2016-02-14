<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('table_logs', function(Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->string('table','255')->nullable();
        	$table->string('column','255')->nullable();
        	$table->string('value','255')->nullable();        	
        	$table->unsignedInteger('pk_id')->index()->default(0);
        	$table->unsignedInteger('updated_by')->index()->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('table_logs');
    }
}
