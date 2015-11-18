<?php

namespace App\Http\Middleware;

use Closure;

class CacheRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if($jsonFile = $this->isCached($request))
    	{
    		return response()->json(file_get_contents($jsonFile));	
    	}
    	
        return $next($request);
    }
    
    /**
     * 
     * @param unknown $request
     * @return boolean
     */
    public function isCached($request)
    {
    	$cached = false;
    	
    	return $cached;
    }
}
