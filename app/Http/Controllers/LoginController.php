<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{

    public function Login(Request $request)
    {
        return view('login');
    } // End Method

    public function stutechlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
// Check if the timestamp query parameter is present in the URL
        // $timestamp = $request->query('timestamp');
        // Set a session variable to indicate that the user is logged in
        Session::put('is_authenticated', true);
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

           if ($user->role_id == 2) {
                // Student
                return redirect('/student/dashboard');
            } elseif ($user->role_id == 3) {
                // Teacher
                return redirect('/teacher/dashboard');
            }
        }

        // If authentication fails, redirect back with an error message
        // return redirect()->back()->withInput()->withErrors(['login' => 'Invalid credentials']);
         // If authentication fails, redirect back with specific error messages
    $errors = [];
    
    // Check if the email exists in the database
    $user = User::where('email', $request->input('email'))->first();
    if (!$user) {
        $errors['email'] = 'Email not found. Please try again.';
    } else {
        $errors['login'] = 'Incorrect Password. Please try again.';
    }
    // Clear the old email value if both email and password are incorrect
    // if (count($errors) == 2) {
    //     $request->session()->forget('email');
    // }

    return redirect()->back()->withErrors($errors)->withInput($request->except('password'));
    // return redirect()->back()->withInput()->withErrors($errors);
    // return redirect()->back()->withErrors($errors)->withInput(['email' => $request->input('email')]);
   
    }
}
