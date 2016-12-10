<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnItemFlexiDeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('txn_item_flexi_deal', function(Blueprint $table) {
    		$table->integer('deal_id');    		
    		$table->string('deal_code', 90)->index();
    		$table->string('item_code', 20)->index();
    		$table->string('uom_code', 20)->index();
    		$table->integer('item_qty')->nullable();
    		$table->string('trade_item_code', 20)->index();
    		$table->string('trade_uom_code', 20)->index();
    		$table->integer('trade_item_qty');
    		$table->string('deal_description', 400)->index();    		
    		$table->decimal('price')->default(0.00);
    		$table->string('salesman_code', 20)->index();    		
    		$table->string('status', 2);
    		$table->string('modified_by', 50)->index();
    		$table->dateTime('modified_date')->nullable();
    		$table->dateTime('sfa_modified_date')->nullable();
    		$table->decimal('version')->nullable();
    		$table->dateTime('updated_at')->nullable();
    		$table->integer('updated_by')->index()->default('0');
    		$table->primary('deal_id');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('txn_item_flexi_deal');
    }
}
