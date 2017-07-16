<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRemittancesRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->float('cash_amount')->change();
            $table->float('check_amount')->change();
        });

        Schema::table('remittance_expenses', function (Blueprint $table) {
            $table->float('amount')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->integer('cash_amount')->change();
            $table->integer('check_amount')->change();
        });

        Schema::table('remittance_expenses', function (Blueprint $table) {
            $table->integer('amount')->change();
        });
    }
}
