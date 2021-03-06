<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class CheckAuthenticatedUser
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

        $userName = Session::get('username');
        $userId = Session::get('userId');
        
        if(!($userId)){
            return redirect()->route('admin.login')->with('error','Unauthorized user');
        }
        return $next($request);
    }
}
