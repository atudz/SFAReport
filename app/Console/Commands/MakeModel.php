<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-new
    						{name : The class name}';
    						//{--migration= : Create a new migration file for the model.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model.';

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
        if($name = $this->argument('name'))
        {
        	$argument = ['name' => $name];
        	/* if($this->argument('migration'))
        	{
        		$argument['--migration'] = 'default'; 
        	} */
        	$this->callSilent('make:model',$argument);
        	
        		$path = __DIR__ . '/../../'.$name.'.php';

        		if(file_exists($path))
        		{
        			$newpath = __DIR__ . '/../../Http/Models/'.$name.'.php';
        			if(!file_exists($newpath))
        			{
	        			$contents = file_get_contents($path);
	        			$contents = str_replace('App', 'App\Http\Models', $contents);
	      				$contents = str_replace('extends Model', 'extends ModelCore', $contents);
	      				if(false !== file_put_contents($newpath, $contents))
	      				{
	      					chmod($newpath,0766);
	      					unlink($path);
	      					$this->info('Model created successfully.');
	      				}
        			}
        			else 
        			{
        				$this->error($name . ' already exist.');
        			}
        		}
        	 
        }
        else
        {
        	$this->error('No classname provided.');
        }
    }
}
