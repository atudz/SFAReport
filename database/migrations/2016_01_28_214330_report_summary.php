<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_summary', function(Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->string('report',255);
        	$table->integer('count')->default('0');
		});
    	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('report_summary');
    }
}
