<?php

namespace app\Http\Middleware;

use app\Mappers\QueryMapper;
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
        $user = $request->user();

        if(is_null($user)){
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $queryBuilder = new QueryMapper(['username' => $user->username],'user_permission');
        $permissions = $queryBuilder->get();

        if(empty($permissions)){
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $roles = array_column($permissions, 'permName');

        if(in_array($request->path(), $roles)){
            return $next($request);
        } else {
            return response()->json(['message' => 'Access Denied'], 403);
        }

    }
}