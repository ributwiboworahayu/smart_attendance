<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProtectUserMobile
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isSuperAdmin = User::where('id', Auth::id())->whereHas('roles', function ($query) {
            $query->where('key', 'superadmin');
        })->exists();

        // compact to view isSuperAdmin
        view()->share('isSuperAdmin', $isSuperAdmin);
        return $next($request);
    }
}
