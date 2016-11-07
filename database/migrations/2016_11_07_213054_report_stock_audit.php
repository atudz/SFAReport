<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportStockAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('report_stock_audit', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->decimal('canned',14,2)->default(0.00);
    		$table->decimal('frozen',14,2)->default(0.00);    		
    		$table->unsignedInteger('reference_id')->index();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('report_stock_audit');
    }
}
