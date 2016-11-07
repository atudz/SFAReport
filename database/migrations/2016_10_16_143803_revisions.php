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
    	Schema::create('report_revisions', function (Blueprint $table) {
    		$table->increments('id');    		
    		$table->timestamps();
    		$table->string('revision_number')->index();
    		$table->string('report')->index();    
    		$table->unsignedInteger('user_id')->index()->nullable();
    		$table->unsignedInteger('table_log_id')->index()->nullable();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('report_revisions');
    }
}
