<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // if expected response is JSON or request to /api/*, make abort with 401
        if ($request->expectsJson() || $request->is('api/*')) {
            abort(401);
        } else {
            return route('login');
        }
    }
}
