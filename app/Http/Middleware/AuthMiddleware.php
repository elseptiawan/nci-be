<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponseHelper;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated via the 'api' guard
        if (Auth::guard('api')->guest()) {
            return ApiResponseHelper::error('Unauthorized', 401);
        }

        return $next($request);
    }
}
