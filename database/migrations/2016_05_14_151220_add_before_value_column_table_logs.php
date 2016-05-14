<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeforeValueColumnTableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_logs', function(Blueprint $table) {
        	$table->string('before','255')->nullable();        	        	
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('table_logs', function(Blueprint $table) {
    		$table->dropColumn('before');
    	});
    }
}
