<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveColumnMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('navigation', function(Blueprint $table) {
			$table->unsignedTinyInteger('active')->default(1);
		});
        
        Schema::table('navigation_item', function(Blueprint $table) {
        	$table->unsignedTinyInteger('active')->default(1);
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
			$table->dropColumn('active');
		});
        
        Schema::table('navigation_item', function(Blueprint $table) {
        	$table->dropColumn('active');
        });
    }
}
