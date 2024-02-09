<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminOnly extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated or token expired'
            ], 401);
        }

        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'User not authorized to perform this action'
            ], 403);
        }

        return $next($request);
    }
}