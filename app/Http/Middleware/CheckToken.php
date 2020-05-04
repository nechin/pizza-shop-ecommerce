<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class CheckToken
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
        $token = $request->bearerToken();
        if ($token) {
            $user = User::where('api_token', $token)->first();
            Auth::setUser($user);
        }

        return $next($request);
    }
}
