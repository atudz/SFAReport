<?php

namespace App\Providers;

use Collective\Html\HtmlServiceProvider;

class MacroServiceProvider extends HtmlServiceProvider
{
    
    public function register()
    {
        // Macros must be loaded after the HTMLServiceProvider's
        // register method is called. Otherwise, csrf tokens
        // will not be generated
        parent::register();
    
        // Load macros  
        $path = base_path().'/resources/views/Macros/';
    
        if ($handle = opendir($path)) 
        {
            while (false !== ($entry = readdir($handle))) 
            {
                if ($entry != "." && $entry != "..") {
                    $path_to = $path.$entry;
                    if( is_dir($path_to) ){
                        if ($hd = opendir($path_to)) {
                            while (false !== ($file = readdir($hd))) {
                                if ($file != "." && $file != "..") {
                                    require $path_to. '/' .$file;
                                }
                            }
                        }
                    }else {
                        require $path.$entry;
                    }

                }
            }
            closedir($handle);
        }
    }
    
}
