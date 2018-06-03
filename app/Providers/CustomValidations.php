<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Factories\ModelFactory;

class CustomValidations extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	Validator::extend('numeric', function ($attribute, $value, $parameters, $validator) {
    		return preg_match('/\d/', $value);
    	});
    	
    	Validator::extend('positive', function ($attribute, $value, $parameters, $validator) {
    		return ((int)$value) >= 0;
    	});
    	
    	Validator::extend('available', function ($attribute, $value, $parameters, $validator) {
    		$condition = $value.' between invoice_start and invoice_end and deleted_at is null and status=\'A\'';
    		$id = array_shift($parameters);
    		if($id)
    			$condition .= ' and id <> '.$id;
    		return !(\DB::table('invoice')->whereRaw($condition)->count() > 0);
    	});
    	
    	Validator::extend('gte', function ($attribute, $value, $parameters, $validator) {    		
    		$name = array_shift($parameters);
    		if($name)
    			return ((int)$value) >= ((int)request()->get($name));
    		return true;
    	});
    	
    	Validator::extend('lte', function ($attribute, $value, $parameters, $validator) {
    		$name = array_shift($parameters);
    		if($name)
    			return ((int)$value) <= ((int)request()->get($name));
    		return true;
    	});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
