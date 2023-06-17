<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Cookie;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        
        if (! $request->expectsJson()) {
            $loginPrefix =  isset($_COOKIE['loginPrefix']) ? $_COOKIE['loginPrefix'] : '';
            if(!empty($loginPrefix)){
                return url("{$loginPrefix}/login");
            }else{
                return route('login');
            }
            
        }
    }
}
