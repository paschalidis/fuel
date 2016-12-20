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
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $queryBuilder = new QueryMapper(['username' => $user->username],'user_permissions');
        $permissions = $queryBuilder->get();

        if(empty($permissions)){
            return response()->json(['message' => 'Access Denied.'], 403);
        }

        $hasAccess = false;
        foreach ($permissions as $permission) {
            if (!$request->isMethod($permission->method)) {
                continue;
            }
            if ($request->is($permission->permName)) {
                $hasAccess = true;
                break;
            }
            if ($request->is($permission->permName . '/*')) {
                $hasAccess = true;
                break;
            }
        }

        if($hasAccess){
            return $next($request);
        } else {
            return response()->json(['message' => 'Access Denied'], 403);
        }

    }
}