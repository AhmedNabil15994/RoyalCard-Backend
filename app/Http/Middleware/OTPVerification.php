<?php

namespace App\Http\Middleware;


use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPVerification
{

    public function handle(Request $request, \Closure $next, ...$guards)
    {
        if(!auth()->user()->otp_verified && auth()->user()->two_factor){
            return redirect()->route('dashboard.auth.verify');
        }

        return $next($request);
    }
}
