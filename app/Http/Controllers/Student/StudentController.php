<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grade;
use App\Models\GradeReportCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function StudentDashboard()
    {
        $id = Auth::user()->id;
        $userName = Auth::user()->name;
        $userData = User::find($id);
         // Get the currently authenticated student's ID
    $studentId = Auth::id();

    // Fetch the grade records for the student
    // $grades = Grade::where('user_id', $studentId)->get();
    $grades = Grade::with('assign_subject.school_subject')
        ->where('user_id', $studentId)
        ->get();


        return view('student.index',compact('userData', 'grades','userName'));
    }

    // public function Download($id, $type)
    // {
    //     // $report = GradeReportCard::findOrFail($id);
    //     // Get the currently authenticated student's ID
    // $studentId = Auth::id();
    
    // // Fetch the GradeReportCard based on the $id and the user_id
    // $report = GradeReportCard::where('id', $id)
    //     ->where('user_id', $studentId)
    //     ->firstOrFail();
    //     if ($type === 'pdf') {
    //     // Check if the PDF file exists
    //     if ($report->pdf_file_path && Storage::exists('upload/grade_reports_pdf/' . $report->pdf_file_path)) {
    //         $pdfFilePath = public_path('upload/grade_reports_pdf' . $report->pdf_file_path); // Use public_path() to get the correct public directory path
    //        // $pdfFileName = 'custom_pdf_name.pdf';
    //         // return response()->download($pdfFilePath, $pdfFileName);
    //        // Set content disposition header for PDF download
    //        $headers = [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'attachment; filename="' . basename($pdfFilePath) . '"',
    //     ];
    //         return response()->download($pdfFilePath, basename($pdfFilePath));
    //     }
    
    //    }elseif ($type === 'image') {
    //       // Check if the image file exists
    //     if ($report->image_file_path && Storage::exists('upload/grade_reports_img/' . $report->image_file_path)) {
    //         $imageFilePath = public_path('upload/grade_reports_img' . $report->image_file_path); // Use public_path() to get the correct public directory path
    //         // $imageFileName = 'custom_image_name.jpg'; // Provide a custom name for image file
    //         // return response()->download($imageFilePath, $imageFileName);
    //         $headers = [
    //             'Content-Type' => 'image/jpeg', // Change this to the appropriate image content type if needed
    //             'Content-Disposition' => 'attachment; filename="' . basename($imageFilePath) . '"',
    //         ];
    //         return response()->download($imageFilePath, basename($imageFilePath));
    //     }
    //    }
    //     // If both file paths are empty or the files do not exist, redirect back with an error message
    //     return redirect()->back()->with('error', 'File not found.');
    // }

    public function Download($id, $type)
{
    // Get the currently authenticated student's ID
    $studentId = Auth::id();

    // Fetch the GradeReportCard based on the $id and the user_id
    $report = GradeReportCard::where('id', $id)
        ->where('user_id', $studentId)
        ->firstOrFail();

    // Check if the PDF file should be downloaded
    if ($type === 'pdf') {
        // Check if the PDF file exists
        $pdfFilePath = public_path('upload/grade_reports_pdf'. DIRECTORY_SEPARATOR . $report->pdf_file_path);
        // if (Storage::exists('upload/grade_reports_pdf' . $report->pdf_file_path)) {
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . basename($pdfFilePath) . '"',
            ];
          
        // }
       
        return response()->download($pdfFilePath, basename($pdfFilePath));
    }
    // Check if the image file should be downloaded
    elseif ($type === 'image') {
        // Check if the image file exists
        $imageFilePath = public_path('upload/grade_reports_img'. DIRECTORY_SEPARATOR . $report->image_file_path);
        // if (Storage::exists('upload/grade_reports_img' . $report->image_file_path)) {
            $headers = [
                'Content-Type' => 'image/jpeg', // Change this to the appropriate image content type if needed
                'Content-Disposition' => 'attachment; filename="' . basename($imageFilePath) . '"',
            ];
           
        // }
     
        return response()->download($imageFilePath, basename($imageFilePath));
    }

    // If the file path is empty or the file does not exist, redirect back with an error message
    return redirect()->back()->with('error', 'File not found.');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function StudentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Student Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }// End Method
}
