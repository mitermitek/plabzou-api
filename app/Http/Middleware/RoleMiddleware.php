<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        foreach ($roles as $role) {
            if (!!$user->$role) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Pas autorisé'], 401);
    }
}
