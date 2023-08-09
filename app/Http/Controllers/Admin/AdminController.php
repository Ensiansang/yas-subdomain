<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Addminlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the admin
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id == 1) {
                // Admin
                return redirect('/admin/dashboard');
            }
        }

        // If authentication fails, redirect back with an error message
        // return redirect()->back()->withInput()->withErrors(['login' => 'Invalid credentials']);

        // If authentication fails, redirect back with specific error message
    // $errors = [
    //     'login' => 'Invalid credentials.',
    // ];

    // // Check if the email exists in the database
    // $user = User::where('email', $request->input('email'))->first();
    // if ($user && $user->role_id != 1) {
    //     $errors['login'] = 'You are not authorized to access the admin area.';
    // }

    // return redirect()->back()->withInput()->withErrors($errors);
    $errors = [];

// Check if the email exists in the database
$user = User::where('email', $request->input('email'))->first();
if (!$user) {
    $errors['login'] = 'Email not found. Please try again.';
} elseif ($user->role_id != 1) {
    $errors['login'] = 'You are not authorized to access the admin area.';
} else {
    $errors['login'] = 'Incorrect password. Please try again.';
}

return redirect()->back()->withInput()->withErrors($errors);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function AdminLogin()
    {
        return view('admin.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Admin Logout Successfully',
            'alert-type' => 'success'
        ];

        return redirect('admin/login')->with($notification);

        // Auth::logout();
        // return redirect('admin/login');
        
    }// End Method
}
