<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\ModelFactory;

class ChangeAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:admin_password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset global admin password.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$email = config('system.reset_password_recipients');
    	if($email)
    	{    		
    		$newPassword = str_random(15);			
    		$user = ModelFactory::getInstance('User')->find(1);
    		if($user)
    		{
    			$user->password = bcrypt($newPassword);
    			if($user->save())
    			{
    				$email = explode(',',$email);
    				$data['password'] = $newPassword;
    				$data['from'] = config('system.from');    				
    				\Mail::send('emails.reset_password', $data, function ($m) use ($email) {
    					$m->from(config('system.from_email'),config('system.from'));
    					$m->to($email)->subject('Reset Password');
    				});
    			}
    		}
    		
    		
    	}        
    }
}
