<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterActionAndAddMessagesToUserActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->string('action_identifier',50)->after('navigation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->dropColumn('action_identifier');
        });
    }
}
