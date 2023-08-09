<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class ErrorController extends Controller
{
    public function handle404(Request $request)
{
    // Get the authenticated user (if any)
    // $user = auth()->user();
    $user = $request->user();

    // Check if the user is authenticated and has a specific role_id
    // if ($user && $user->role_id == 1) {
    //     // Redirect the student user back to the student dashboard
    //     return redirect('/student/dashboard')->with('message', 'Back to student dashboard');
    // } elseif ($user && $user->role_id == 2) {
    //     // Redirect the teacher user back to the teacher dashboard
    //     return redirect('/teacher/dashboard')->with('message', 'Back to teacher dashboard');
    // } elseif ($user && $user->role_id == 3) {
    //     // Redirect the admin user back to the admin dashboard
    //     return redirect('/admin/dashboard')->with('message', 'Back to admin dashboard');
    // } else {
    //     // Redirect unregistered users to the login page
    //     return redirect('/login')->with('message', 'Back to login');
    // }
    // return view('ahmr.404');
    if ($user) {
        // Redirect the user based on their role
        if ($user->role_id == 1) {
            return redirect()->route('student.dashboard')->with('message', 'Back to student dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('teacher.dashboard')->with('message', 'Back to teacher dashboard');
        } elseif ($user->role_id == 3) {
            return redirect()->route('admin.dashboard')->with('message', 'Back to admin dashboard');
        }
    }

    // Redirect unregistered users to the login page
    return redirect()->route('login')->with('message', 'Back to login');
}

}
