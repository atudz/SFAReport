<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustmentChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('replenishment', function (Blueprint $table) {
    		$table->string('adjustment_reason')->nullable();    		    		
    	});
    	
    	Schema::table('replenishment_item', function (Blueprint $table) {
    		$table->string('brand_code')->nullable()->index();
    		$table->string('remarks')->nullable();    		
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
