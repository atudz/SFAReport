<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByBounceCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('bounce_check', function (Blueprint $table) {
    		$table->unsignedInteger('created_by')->nullable()->index();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('bounce_check', function (Blueprint $table) {
    		$table->dropColumn('created_by');
    	});
    }
}
