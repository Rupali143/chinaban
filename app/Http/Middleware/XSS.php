<?php

namespace App\Http\Middleware;
use Validator;
use Closure;
use Illuminate\Http\Request;

class XSS
{
    /**
     * Handle an incoming XSS Attack request.
     *@ Rupali Satpute <rupali.satpute@neosofttech.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return $request data
     */

    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
        });
        $request->merge($input);
        return $next($request);
    }
}
