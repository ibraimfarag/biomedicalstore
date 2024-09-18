<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Find the user by ID in the User model
            $user = User::find($userId);

            // Check if the user has the required permission
            if ($user && $user->hasPermission($permission)) {
                return $next($request);
            }
        }

        // If permission is not found, redirect to an unauthorized page
        return redirect()->route('unauthorized');
    }
}
