<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostedDateReplenishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('replenishment', function (Blueprint $table) {    		
    		$table->dateTime('posted_date')->index()->nullable();
    		$table->unsignedInteger('posted_by')->index()->nullable();
    	});
    	
    	Schema::table('replenishment_item', function (Blueprint $table) {
    		$table->dateTime('posted_date')->index()->nullable();
    		$table->unsignedInteger('posted_by')->index()->nullable();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('replenishment', function (Blueprint $table) {
    		$table->dropColumn(['posted_date','posted_by']);
    	});
    	
    	Schema::table('replenishment_item', function (Blueprint $table) {
    		$table->dropColumn(['posted_date','posted_by']);
    	});
    }
}
