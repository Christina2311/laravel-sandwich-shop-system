<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get all roles in lowercase for safe comparison
        $userRoles = $user->roles->pluck('role_name')
                    ->map(fn($role) => strtolower(trim($role)))
                    ->toArray();

        foreach ($roles as $role) {
            if (in_array(strtolower(trim($role)), $userRoles)) {
                return $next($request);
            }
        }

        // Block unauthorized access
        abort(403, 'Unauthorized. You do not have permission to access this page.');
    }
}