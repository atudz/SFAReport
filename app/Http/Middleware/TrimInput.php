<?php

namespace App\Http\Middleware;

use \Illuminate\Http\Request;
use Closure;

class TrimInput {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        if((array)$input !== $input)
            $request->merge(array_map('trim', $input));

        return $next($request);
    }

}