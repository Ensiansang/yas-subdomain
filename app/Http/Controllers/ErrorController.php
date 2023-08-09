<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class ErrorController extends Controller
{
    public function handle404(Request $request)
{
    
    $user = $request->user();

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
