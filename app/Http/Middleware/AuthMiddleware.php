<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) {
            if(DB::table('userstoken')->where('token', $request->header('Authorization'))->first()){
                return $next($request);
            } else {
                throw new AuthenticationException();
            }
        }

        return $next($request);
    }
}
