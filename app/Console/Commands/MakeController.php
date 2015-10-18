<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Core\ControllerCore;

class MakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller-new
    						{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Controller Class.';
	
    /**
     * The template name
     */
    protected $templateName = 'Controller.stub';
    
    /**
     * The template merge code
     */
    protected $mergeCode = '{classname}';
    
    /**
     * The Controller class suffix
     */
    protected $suffix = 'Controller';
    
    /**
     * The Controller class file extenstion
     */
    protected $ext = '.php';
    
    
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
    	if($classname = $this->argument('name'))
    	{
    		$classname = ucfirst($classname);
    		$template = $this->getTemplateDir().$this->templateName;
    		if(file_exists($template))
    		{
    			if(file_exists(ControllerCore::getControllerDirectory()))
    			{
    				$text = str_replace($this->mergeCode, $classname, file_get_contents($template));
    				$path = ControllerCore::getControllerDirectory().$classname.$this->suffix.$this->ext;
    				 
    				if(!file_exists($path))
    				{
	    				if(false == file_put_contents($path,$text))
	    				{
	    					$this->error('Can\'t write file to '. ControllerCore::getControllerDirectory().$path);
	    				}
	    				else
	    				{
	    					chmod($path,0766);
	    					$this->info($classname. ' Controller class created.');
	    				}
    				}
    				else
    				{
    					$this->error($classname.' already exist');
    				}
    			}
    			else
    			{
    				$this->error('Controller class directory not found '. ControllerCore::getControllerDirectory());
    			}
    		}
    		else
    		{
    			$this->error('Controller class template not found '. $template);
    		}
    	}
    	else
    	{
    		$this->error('No classname provided.');
    	}
    }
    
    
    /**
     * Gets Factory Template directory
     * @return string
     */
    public function getTemplateDir()
    {
    	return __DIR__.'/stubs/';
    }
}
