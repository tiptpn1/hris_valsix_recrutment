<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use KDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        
        if($this->inExceptArray($request))
        {
            return $next($request);
        }


        $token = request()->bearerToken();

        if(empty($token))
        {
            $arrResult["code"] = "000";
            $arrResult["status"] = "failed";
            $arrResult["message"] = "Bearer token required.";
            return response()->json($arrResult);
        }

        $adaData = KDatabase::query(" SELECT COUNT(1) ada FROM user_login_mobile WHERE token = '$token' and status = '1' ")->first_row()->ada;

        if($adaData == 0)
        {
            $arrResult["code"] = "000";
            $arrResult["status"] = "failed";
            $arrResult["message"] = "Token expired.";
            return response()->json($arrResult);
        }

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }

    
    protected $except = [
		'api/login',
		'api/aktivasi',
		'api/aktivasi-otp',
		'api/setup-pin',
		'api/vb-register',
        'api/vb-verify',
        'api/vb-upload-finger'
    ];

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

}
