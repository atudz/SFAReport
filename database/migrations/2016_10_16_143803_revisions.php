<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Revisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('revisions', function (Blueprint $table) {
    		$table->increments('id');    		
    		$table->timestamps();
    		$table->string('revision_number');
    		$table->string('report_type');    		
    		$table->unsignedInteger('modified_by')->index()->nullable();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('revisions');
    }
}
