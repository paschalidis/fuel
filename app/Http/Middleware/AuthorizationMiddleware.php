<?php

namespace app\Http\Middleware;

use Closure;

class AuthorizationMiddleware
{
    /**
     * Handle an incoming request and return the corresponding format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //todo handle permission from database
        $roles = array('api/v1/info');

        if(in_array($request->path(), $roles)){
            return $next($request);
        } else {
            return response()->json(['message' => 'Access Denied'], 403);
        }

    }
}