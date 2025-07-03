<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is authenticated using admin guard
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // If request is AJAX, return JSON response
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. Admin access required.',
                'redirect' => route('admin.login')
            ], 401);
        }

        // For regular requests, redirect to admin login with intended URL
        return redirect()->guest(route('admin.login'));
    }
}
