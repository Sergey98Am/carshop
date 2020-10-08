<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class RoleShopOwner
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
        if (JWTAuth::check() && JWTAuth::user()->isRole() == 2){
            return $next($request);
        }
        return response()->json(['message' => 'You cannot do this'],400);
    }
}
