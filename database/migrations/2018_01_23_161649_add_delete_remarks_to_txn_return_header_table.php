<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteRemarksToTxnReturnHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('txn_return_header', function (Blueprint $table) {
            $table->text('delete_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('txn_return_header', function (Blueprint $table) {
            $table->dropColumn('delete_remarks');
        });
    }
}
