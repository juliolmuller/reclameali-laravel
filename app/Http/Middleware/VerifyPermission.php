<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyPermission
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
        $permissions = Auth::user()->role->permissions;
        $action = class_basename($request->route()->getActionName());

        foreach ($permissions as $permission) {
            if ($action == "{$permission->controller}@{$permission->method}") {

                return $next($request);

            }
        }

        return abort(403);
    }
}
