<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if ($request->user() && $request->user()->authorizeRoles(['operator', 'admin']))
        {
            return $next($request);
        }
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
