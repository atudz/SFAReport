<?php

use Illuminate\Database\Seeder;
use App\Factories\ModelFactory;

class UpdateDeletedUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $deletedUsers = ModelFactory::getInstance('User')->onlyTrashed()->get();
        foreach($deletedUsers as $user)
        {
        	$user->email = $user->email.'.deleted';
        	if($user->name)
        		$user->username = $user->username.'.deleted';
        	$user->save();
        }
    }
}
