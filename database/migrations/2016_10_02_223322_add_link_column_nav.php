<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkColumnNav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('navigation', function(Blueprint $table) {
        	$table->boolean('link')->default(0);        	        	
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('navigation', function(Blueprint $table) {
    		$table->dropColumn('link');
    	});
    }
}
