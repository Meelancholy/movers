<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (Auth::check() && $user->two_factor_code) {
            if (!$request->is('two-factor*') && !$request->is('logout')) {
                return redirect()->route('two-factor.show');
            }
        }

        return $next($request);
    }
}
