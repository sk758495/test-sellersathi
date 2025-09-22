<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) { // Ensure using the admin guard
            return redirect()->route('admin.login'); // Redirect to the admin login page if not authenticated
        }

        return $next($request);  // Continue if authenticated
    }
}
