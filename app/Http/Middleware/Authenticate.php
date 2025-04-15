<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use KAuth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if($this->inExceptArray($request))
            return $next($request);

        if (KAuth::getIdentity() == null) {
            $this->unauthenticated($request, $guards);
        }
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }

    }

    
    protected function inExceptArray($request)
    {

        // var_dump($request->fullUrl());
        // exit;
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except) || stristr($request->fullUrl(), $except)) {
                return true;
            }
        }
        
        return false;
    }

    protected $except = [
        'app/index/syarat_ketentuan',
        'app/index/faq',
        'app/index/home',
        'app/index/home_detil',
        'app/index/password',
        'app/index/aktivasi',
        'app/index/reset_password',
        'app/index/pencarian',
    ];

}
