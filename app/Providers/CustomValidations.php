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
    	Validator::extend('valid_invoice', function ($attribute, $value, $parameters, $validator) {
    		return preg_match('/\d/', $value);
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
