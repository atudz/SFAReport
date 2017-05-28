<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplenishmentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('replenishment_item', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('reference_number')->index();
    		$table->string('item_code')->index()->nullable();
    		$table->string('uom_code')->index()->nullable();
    		$table->integer('quantity')->default(0);
    		$table->string('modified_by',30)->nullable();
    		$table->dateTime('modified_date')->nullable();
    		$table->dateTime('sfa_modified_date')->nullable();
    		$table->string('status',2)->default('A');
    		$table->bigInteger('version')->nullable();    		
    	});
    	
    	Schema::table('replenishment', function (Blueprint $table) {
    		$table->dropColumn('reference_num');
    	});
    	
    	Schema::table('replenishment', function (Blueprint $table) {
    		$table->string('reference_number')->index()->after('updated_at');
    		$table->string('van_code')->index()->after('reference_number');
    		$table->dateTime('replenishment_date')->nullable()->after('van_code');
    		$table->string('modified_by')->nullable()->default('STAGING')->after('replenishment_date');
    		$table->dateTime('modified_date')->nullable()->after('modified_by');
    		$table->dateTime('sfa_modified_date')->nullable()->after('modified_date');
    		$table->enum('type', ['actual_count','adjustment'])->nullable();
    		$table->bigInteger('version')->nullable()->after('last_ddr');
    		$table->string('status',2)->default('A')->after('version');
    		$table->dateTime('posted_date')->nullable()->index();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('replenishment_item');
    }
}
