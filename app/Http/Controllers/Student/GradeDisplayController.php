<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GradeDisplayController extends Controller
{
    public function studentDashboard()
{
    // Get the currently authenticated student's ID
    $studentId = Auth::id();

    // Fetch the grade records for the student
    $grades = Grade::where('user_id', $studentId)->get();

    // Pass the grades to the view
    return view('student.dashboard', compact('grades'));
}
}
