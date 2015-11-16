<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Core\FactoryCore;

class MakeFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:factory
    						{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new factory class.';

    /**
     * The template name
     */
    protected $templateName = 'Factory.stub';
    
    /**
     * The template merge code
     */
    protected $mergeCode = '{classname}';
    
    /**
     * The Factory class suffix
     */
    protected $suffix = 'Factory';
    
    /**
     * The Factory class file extenstion
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
        		if(file_exists(FactoryCore::getFactoryDirectory()))
        		{
        			$text = str_replace($this->mergeCode, $classname, file_get_contents($template));
        			$path = FactoryCore::getFactoryDirectory().$classname.$this->suffix.$this->ext;
        			
        			if(!file_exists($path))
        			{
	        			if(false == file_put_contents($path,$text))
	        			{
	        				$this->error('Can\'t write file to '. FactoryCore::getFactoryDirectory().$path);
	        			}
	        			else
	        			{
	        				chmod($path,0766);
	        				$this->info($classname. ' Factory Class created.');
	        			}
        			}
        			else
        			{
        				$this->error($classname.' already exist.');
        			}
        		}
        		else
        		{
        			$this->error('Factory class directory not found '. FactoryCore::getFactoryDirectory());
        		}
        	}
        	else
        	{
        		$this->error('Factory Class template not found '. $template);
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
