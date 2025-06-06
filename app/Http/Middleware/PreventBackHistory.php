<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $headers = [
            'Cache-Control'         => 'nocache, no-store, max-age=0, must-revalidate',
            'Pragma'                => 'no-cache',
            'Expires'               => 'Sun, 02 Jan 1990 00:00:00 GMT'
        ];
        foreach($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }
}
