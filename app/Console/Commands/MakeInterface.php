<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface
    					    {name : The interface name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create\'s new interface class.';
    
    /**
     * The template name
     */
    protected $templateName = 'Interface.stub';
    
    /**
     * The template merge code
     */
    protected $mergeCode = '{interfacename}';
    
    /**
     * The Controller class suffix
     */
    protected $suffix = 'Interface';
    
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
        //
    	if($interfacename = $this->argument('name'))
    	{
    		$interfacename = ucfirst($interfacename);
    		$template = $this->getTemplateDir().$this->templateName;
    		if(file_exists($template))
    		{
    			if(file_exists($this->getInterfaceDirectory()))
    			{
    				$text = str_replace($this->mergeCode, $interfacename, file_get_contents($template));
    				$path = $this->getInterfaceDirectory().$interfacename.$this->suffix.$this->ext;
    					
    				if(!file_exists($path))
    				{
	    				if(false == file_put_contents($path,$text))
	    				{
	    					$this->error('Can\'t write file to '. $this->getInterfaceDirectory().$path);
	    				}
	    				else
	    				{
	    					chmod($path,0766);
	    					$this->info($interfacename. ' Interface created.');
	    				}
    				}
    				else
    				{
    					$this->error($interfacename .' already exist.');
    				}
    			}
    			else
    			{
    				$this->error('Interface directory not found '. $this->getInterfaceDirectory());
    			}
    		}
    		else
    		{
    			$this->error('Interface template not found '. $template);
    		}
    	}
    	else
    	{
    		$this->error('No interfacename provided.');
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
    
    /**
     * Gets Factory Template directory
     * @return string
     */
    public function getInterfaceDirectory()
    {
    	return __DIR__.'/../../Interfaces/';
    }
}
