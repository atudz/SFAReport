<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToUserGroupToNavPermissionOverridesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_group_to_nav_permission_overrides', function (Blueprint $table) {
            $table->enum('status', ['allowed', 'denied','inherit']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_group_to_nav_permission_overrides', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
