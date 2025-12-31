<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        
        // Support multiple roles (e.g., role:admin|user)
        if (!in_array($userRole, $roles)) {
            // Redirect based on user's actual role
            if ($userRole === 'admin') {
                return redirect()->route('user.index');
            }
            return redirect()->route('homepage');
        }
        
        return $next($request);
    }
}
