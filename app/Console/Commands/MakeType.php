<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\TypeFactory;
use App\Core\TypeCore;

class MakeType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:type
    						{name : The type class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Type class.';
    
    /**
     * The template name
     */
    protected $templateName = 'Type.stub';
    
    /**
     * The template merge code
     */
    protected $mergeCode = '{classname}';
    
    /**
     * The Controller class suffix
     */
    protected $suffix = 'Type';
    
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
    	if($classname = $this->argument('name'))
    	{
    		$classname = ucfirst($classname);
    		$template = $this->getTemplateDir().$this->templateName;
    		if(file_exists($template))
    		{
    			if(file_exists(TypeCore::getTypeDirectory()))
    			{
    				$text = str_replace($this->mergeCode, $classname, file_get_contents($template));
    				$path = TypeCore::getTypeDirectory().$classname.$this->suffix.$this->ext;
    					
    				if(!file_exists($path))
    				{
	    				if(false == file_put_contents($path,$text))
	    				{
	    					$this->error('Can\'t write file to '. TypeCore::getTypeDirectory().$path);
	    				}
	    				else
	    				{
	    					chmod($path,0766);
	    					$this->info($classname. ' Type class created.');
	    				}
    				}
    				else
    				{
    					$this->error($classname.' already exist.');
    				}
    			}
    			else
    			{
    				$this->error('Type class directory not found '. TypeCore::getTypeDirectory());
    			}
    		}
    		else
    		{
    			$this->error('Type class template not found '. $template);
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
