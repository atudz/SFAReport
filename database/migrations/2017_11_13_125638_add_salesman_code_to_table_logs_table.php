<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalesmanCodeToTableLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_logs', function (Blueprint $table) {
            $table->string('salesman_code', 20)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_logs', function (Blueprint $table) {
            $table->dropColumn('salesman_code');
        });
    }
}
