<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	\DB::statement('ALTER TABLE `user` ADD INDEX `gender` (`gender`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `last_login_date` (`last_login_date`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `location_assignment_code` (`location_assignment_code`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `location_assignment_type` (`location_assignment_type`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `location_assignment_from` (`location_assignment_from`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `location_assignment_to` (`location_assignment_to`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `status` (`status`)');
    	\DB::statement('ALTER TABLE `user` ADD INDEX `salesman_code` (`salesman_code`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
