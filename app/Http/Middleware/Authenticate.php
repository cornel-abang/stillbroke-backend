<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated or token expired'
            ], 401);
        }

        return $next($request);
    }
}