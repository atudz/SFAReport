 <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TxnReturnDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txn_return_detail', function(Blueprint $table) {
        	$table->integer('return_detail_id');
			$table->string('return_txn_number', 20)->nullable();
			$table->string('reason_code', 20)->index();
			$table->string('item_code', 20)->index();
			$table->string('condition_code', 20);
			$table->decimal('gross_amount');
			$table->decimal('discount_amount');
			$table->decimal('vat_amount');
			$table->string('uom_code', 20)->index();
			$table->integer('quantity');
			$table->string('status', 2)->default('P');
			$table->string('item_status', 2);
			$table->string('modified_by', 50)->index();
			$table->dateTime('modified_date')->nullable();
			$table->dateTime('sfa_modified_date')->nullable();
			$table->string('device_code', 20)->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->integer('updated_by')->index()->default('0');
			$table->primary('return_detail_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('txn_return_detail');
    }
}
