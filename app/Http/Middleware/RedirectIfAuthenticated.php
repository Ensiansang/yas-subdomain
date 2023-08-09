<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //          //return redirect(RouteServiceProvider::HOME);
        //         if(Auth::check() && Auth::user()->role_id == 2){
        //             return redirect('/student/dashboard');

        //         }if(Auth::check() && Auth::user()->role_id == 3){
        //             return redirect('/teacher/dashboard');

        //         }if(Auth::check() && Auth::user()->role_id == 1){
        //             return redirect('/admin/dashboard');

        //         }
        //     }
        // }

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch (Auth::user()->role_id) {
                    case 2: // Student role_id
                        return redirect('/student/dashboard');
                    case 3: // Teacher role_id
                        return redirect('/teacher/dashboard');
                    case 1: // Admin role_id
                        return redirect('/admin/dashboard');
                    default:
                        return redirect(RouteServiceProvider::HOME); // Fallback if role_id doesn't match any cases
                }
            }
        }

        return $next($request);
    }
}
