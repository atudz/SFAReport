<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class InvoiceSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('invoice', function (Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('salesman_code')->index();
    		$table->string('area_code')->index();
    		$table->string('invoice_start')->index();
    		$table->string('invoice_end')->index();
    		$table->enum('status',['A','I'])->default('A');
    		$table->text('remarks')->nullable();
    		$table->softDeletes();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice');
    }
}
