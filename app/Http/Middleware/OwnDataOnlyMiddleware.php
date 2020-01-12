<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnDataOnlyMiddleware
{
    /**
     * List of roles' names that are must have the HTTP header added
     *
     * @var array
     */
    private const ROLES = ['customer'];

    /**
     * HTTP header added to request
     *
     *@var string
     */
    public const HEADER = 'Own-Data-Only';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $currentUserRole = auth()->user()->role->name;

            if (in_array($currentUserRole, self::ROLES)) {
                $request->headers->set(self::HEADER, 'true');
            }
        }

        return $next($request);
    }
}
