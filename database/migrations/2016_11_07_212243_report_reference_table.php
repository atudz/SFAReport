<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('report_references', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('reference_number')->index();
    		$table->string('revision_number')->nullable()->index();
    		$table->string('report')->index();;
    		$table->dateTime('from')->nullable();
    		$table->dateTime('to')->nullable();
    		$table->string('salesman')->nullable()->index();
    		$table->unsignedInteger('user_id')->index()->nullable();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('report_references');
    }
}
