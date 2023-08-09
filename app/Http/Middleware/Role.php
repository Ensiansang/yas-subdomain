<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Role
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */

/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next, $role): Response
    {
        // Get the authenticated user
    // $user = Auth::user();
    // if ($user && $user->role_id == $role) {
    //     return $next($request);
    // }
    // return redirect('/');

    // if ($role == 'admin' && auth()->user()->role_id != 1) {
    //     abort(403);
    // }

    // if ($role == 'student' && auth()->user()->role_id != 2) {
    //     abort(403);
    // }

    // if ($role == 'teacher' && auth()->user()->role_id != 3) {
    //     abort(403);
    // }

            // Get the authenticated user
            $user = Auth::user();

            // Check if the user has the required role
            if ($user && $user->role_id == $role) {
                return $next($request);
            }
    
            // Redirect or return a response based on the user's role
            if ($role == 2) { // Student
                return redirect()->route('student.dashboard');
            } elseif ($role == 3) { // Teacher
                return redirect()->route('teacher.dashboard');
            } elseif ($role == 1) { // Admin
                return redirect()->route('admin.dashboard');
            }
    
            // If the role is not recognized or no user is authenticated, redirect to the default route
             return redirect('/');

            // if ($request->user()->role_id !== $role) {
            //     return redirect('/student/dashboard');
            // }
            // return $next($request);
    }
}
