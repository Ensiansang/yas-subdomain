<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\StudentClass;
use App\Models\AssignStudent; 
use App\Models\GradeReportCard;

class GradeReportController extends Controller
{
    public function Img_Pdf_Add(){
        $data['classes'] = StudentClass::all();
        return view('teacher.img_pdf.img_pdf_add',$data);
    }
    public function ImgPdfStudent(Request $request){
        $class_id = $request->class_id;
        $allData = AssignStudent::with(['student'])->where('class_id',$class_id)->get();
         // Fetch already uploaded data for each student
    foreach ($allData as $student) {
        $uploadedData = GradeReportCard::where('user_id', $student->student->id)->get();
        $student->uploadedData = $uploadedData;
    }
        return response()->json($allData);
    }


    public function Upload(Request $request)
    {
        $studentIds = $request->user_id;
        $pdfFiles = $request->file('pdf_file');
        $imageFiles = $request->file('image_file');
    
        // Validate if either a PDF or image file is uploaded for all selected students
        // if (!$pdfFiles && !$imageFiles) {
        //     $notification = array(
        //         'message' => 'Please upload either a PDF or an image file for all selected students.',
        //         'alert-type' => 'error'
        //     );
        //     return back()->with($notification);
        // }
// Validate if at least one of PDF or image file is uploaded for all selected students
        // if (empty(array_filter($pdfFiles)) && empty(array_filter($imageFiles))) {
        //     $notification = array(
        //         'message' => 'Please upload either a PDF or an image file for all selected students.',
        //         'alert-type' => 'error'
        //     );
        //     return back()->with($notification);
        // }

         // Validate if both PDF and image files are uploaded for all selected students
    foreach ($studentIds as $key => $studentId) {
        // if (empty($pdfFiles[$key]) || empty($imageFiles[$key])) {
            if (empty($pdfFiles[$key]) && empty($imageFiles[$key])) {
            $notification = array(
                'message' => 'Please upload either a PDF or an image file for all selected students.',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
    
        for ($i = 0; $i < count($studentIds); $i++) {
            $data = new GradeReportCard();
            $data->user_id = $studentIds[$i];
    
            // Process and validate the PDF file if provided
            // $pdfFile = $pdfFiles[$i] ?? null;
             // if (isset($pdfFiles[$i])) {
            // if ($pdfFiles[$i]) {
                 if (isset($pdfFiles[$i])) {
                $pdfValidator = Validator::make(['pdf_file' => $pdfFiles[$i]], [
                    'pdf_file' => 'required|mimes:pdf|max:5120', // Adjust max size and allowed extensions as needed
                ]);
    
                if ($pdfValidator->fails()) {
                    // $notification = array(
                    //     'message' => $pdfValidator->errors()->first('pdf_file'),
                    //     'alert-type' => 'error'
                    // );
                    // return back()->withErrors($notification);
                    return back()->withErrors($pdfValidator->errors()->first('pdf_file'));
                }
               
                // Check if the actual file type is PDF
            if ($pdfFiles[$i]->getMimeType() != 'application/pdf') {
                $notification = array(
                    'message' => 'Please upload a PDF file for the PDF field.',
                    'alert-type' => 'error'
                );
                return back()->withErrors($notification);
            }
    
                // Store and save the PDF file with a flag to identify it as a PDF file
                $pdfFileName = date('Y-m-d') . '_pdf_' . $pdfFiles[$i]->getClientOriginalName();
                $uploadPath = public_path('upload/grade_reports_pdf');
                $pdfFiles[$i]->move($uploadPath, $pdfFileName);
                $data->pdf_file_path  = $pdfFileName;
                $data->pdf_file_type = $pdfFiles[$i]->getClientOriginalExtension();
            }
    
            // Process and validate the image file if provided
            // $imageFile = $imageFiles[$i] ?? null;
            // if (isset($imageFiles[$i])) {
            // if ($imageFiles[$i]) {
             if (isset($imageFiles[$i])) {
                $imageValidator = Validator::make(['image_file' => $imageFiles[$i]], [
                    'image_file' => 'required|mimes:jpeg,jpg,png|max:5120', // Adjust max size and allowed extensions as needed
                ]);
    
                if ($imageValidator->fails()) {
                    // $notification = array(
                    //     'message' => $imageValidator->errors()->first('image_file'),
                    //     'alert-type' => 'error'
                    // );
                    // return back()->withErrors($notification);
                    return back()->withErrors($imageValidator->errors()->first('image_file'));
                }
    
                // Check if the actual file type is an image
            $allowedImageMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($imageFiles[$i]->getMimeType(), $allowedImageMimeTypes)) {
                $notification = array(
                    'message' => 'Please upload an image file (JPEG, JPG, or PNG) for the image field.',
                    'alert-type' => 'error'
                );
                return back()->withErrors($notification);
            }
                // Store and save the image file with a flag to identify it as an image file
                $imageFileName = date('Y-m-d') . '_img_' . $imageFiles[$i]->getClientOriginalName();
                $uploadPath = public_path('upload/grade_reports_img');
                $imageFiles[$i]->move($uploadPath, $imageFileName);
                $data->image_file_path = $imageFileName;
                $data->image_file_type = $imageFiles[$i]->getClientOriginalExtension();
            }
    
            $data->uploaded_at = now();
            $data->save();
        }
    
        $notification = array(
            'message' => 'Student Data Inserted Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);

    //     $studentIds = $request->user_id;
    // $pdfFiles = $request->file('pdf_file');
    // $imageFiles = $request->file('image_file');

    // // Validate if both PDF and image files are uploaded for all selected students
    // if (!$pdfFiles || !$imageFiles || count($studentIds) !== count($pdfFiles) || count($studentIds) !== count($imageFiles)) {
    //     $notification = array(
    //         'message' => 'Please upload both a PDF and an image file for all selected students.',
    //         'alert-type' => 'error'
    //     );
    //     return back()->with($notification);
    // }

    // for ($i = 0; $i < count($studentIds); $i++) {
    //     $data = new GradeReportCard();
    //     $data->user_id = $studentIds[$i];

    //     // Process and validate the PDF file if provided
    //     if ($pdfFiles[$i]) {
    //         $pdfValidator = Validator::make(['pdf_file' => $pdfFiles[$i]], [
    //             'pdf_file' => 'required|mimes:pdf|max:5120', // Adjust max size and allowed extensions as needed
    //         ]);

    //         if ($pdfValidator->fails()) {
    //             $notification = array(
    //                 'message' => $pdfValidator->errors()->first('pdf_file'),
    //                 'alert-type' => 'error'
    //             );
    //             return back()->withErrors($notification);
    //         }

    //         // Store and save the PDF file
    //         $pdfFileName = date('Y-m-d') . '_' . $pdfFiles[$i]->getClientOriginalName();
    //         $uploadPath = public_path('upload/grade_reports_pdf');
    //         $pdfFiles[$i]->move($uploadPath, $pdfFileName);
    //         $data->file_path = $pdfFileName;
    //         $data->file_type = $pdfFiles[$i]->getClientOriginalExtension();
    //     }

    //     // Process and validate the image file if provided
    //     if ($imageFiles[$i]) {
    //         $imageValidator = Validator::make(['image_file' => $imageFiles[$i]], [
    //             'image_file' => 'required|mimes:jpeg,jpg,png|max:5120', // Adjust max size and allowed extensions as needed
    //         ]);

    //         if ($imageValidator->fails()) {
    //             $notification = array(
    //                 'message' => $imageValidator->errors()->first('image_file'),
    //                 'alert-type' => 'error'
    //             );
    //             return back()->withErrors($notification);
    //         }

    //         // Store and save the image file
    //         $imageFileName = date('Y-m-d') . '_' . $imageFiles[$i]->getClientOriginalName();
    //         $uploadPath = public_path('upload/grade_reports_img');
    //         $imageFiles[$i]->move($uploadPath, $imageFileName);
    //         $data->file_path = $imageFileName;
    //         $data->file_type = $imageFiles[$i]->getClientOriginalExtension();
    //     }

    //     $data->uploaded_at = now();
    //     $data->save();
    // }

    // $notification = array(
    //     'message' => 'Student Data Inserted Successfully',
    //     'alert-type' => 'success'
    // );

    // return redirect()->back()->with($notification);

   
    // $studentIds = $request->user_id;
    // $pdfFiles = $request->file('pdf_file');
    // $imageFiles = $request->file('image_file');

    // // Validate if both PDF and image files are uploaded for all selected students
    // if (!$pdfFiles || !$imageFiles || count($studentIds) !== count($pdfFiles) || count($studentIds) !== count($imageFiles)) {
    //     $notification = array(
    //         'message' => 'Please upload both a PDF and an image file for all selected students.',
    //         'alert-type' => 'error'
    //     );
    //     return back()->with($notification);
    // }

    // for ($i = 0; $i < count($studentIds); $i++) {
    //     $data = new GradeReportCard();
    //     $data->user_id = $studentIds[$i];

    //     // Process and validate the PDF file if provided
    //     if ($pdfFiles[$i]) {
    //         $pdfValidator = Validator::make(['pdf_file' => $pdfFiles[$i]], [
    //             'pdf_file' => 'required|mimes:pdf|max:5120', // Adjust max size and allowed extensions as needed
    //         ]);

    //         if ($pdfValidator->fails()) {
    //             $notification = array(
    //                 'message' => $pdfValidator->errors()->first('pdf_file'),
    //                 'alert-type' => 'error'
    //             );
    //             return back()->withErrors($notification);
    //         }

    //         // Store and save the PDF file
    //         $pdfFileName = date('Y-m-d') . '_' . $pdfFiles[$i]->getClientOriginalName();
    //         $uploadPath = public_path('upload/grade_reports_pdf');
    //         $pdfFiles[$i]->move($uploadPath, $pdfFileName);
    //         $data->pdf_file_path = $pdfFileName;
    //     }

    //     // Process and validate the image file if provided
    //     if ($imageFiles[$i]) {
    //         $imageValidator = Validator::make(['image_file' => $imageFiles[$i]], [
    //             'image_file' => 'required|mimes:jpeg,jpg,png|max:5120', // Adjust max size and allowed extensions as needed
    //         ]);

    //         if ($imageValidator->fails()) {
    //             $notification = array(
    //                 'message' => $imageValidator->errors()->first('image_file'),
    //                 'alert-type' => 'error'
    //             );
    //             return back()->withErrors($notification);
    //         }

    //         // Store and save the image file
    //         $imageFileName = date('Y-m-d') . '_' . $imageFiles[$i]->getClientOriginalName();
    //         $uploadPath = public_path('upload/grade_reports_img');
    //         $imageFiles[$i]->move($uploadPath, $imageFileName);
    //         $data->image_file_path = $imageFileName;
    //     }

    //     $data->uploaded_at = now();
    //     $data->save();
    // }

    // $notification = array(
    //     'message' => 'Student Data Inserted Successfully',
    //     'alert-type' => 'success'
    // );

    // return redirect()->back()->with($notification);


        // $studentCount = $request->user_id;

        // if ($studentCount) {
        //     for ($i = 0; $i < count($request->user_id); $i++) {
        //         $data = new GradeReportCard();
        //         $data->user_id = $request->user_id[$i];
        //         $pdfFile = $request->file('pdf_file')[$i];

        //         if ($pdfFile) {
        //             // Validate the uploaded PDF file
        //             $pdfValidator = Validator::make(['pdf_file' => $pdfFile], [
        //                 // 'pdf_file' => 'required|mimes:pdf|max:2048', // Adjust max size and allowed extensions as needed
        //                 'pdf_file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', // Allow PDF, JPEG, JPG, PNG files up to 5MB
        //             ]);
    
        //             if ($pdfValidator->fails()) {
        //                 $notification = [
        //                     'message' => $pdfValidator->errors()->first('pdf_file'),
        //                     'alert-type' => 'error'
        //                 ];
        //                 return back()->withErrors($pdfValidator)->with($notification);
        //             }
    
        //             // Store the PDF file on the server
        //             // $pdfFile->storeAs('pdf_uploads', $pdfFileName);
        //             // $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
        //             $pdfFileName = date('Y-m-d') . '_' . $pdfFile->getClientOriginalName(); 
                    
        //             $uploadPath = public_path('upload/grade_reports');
        //             $pdfFile->move($uploadPath, $pdfFileName);
    
        //             // Save the file path to the database
        //             $data->file_path = $pdfFileName;
        //             $data->file_type = $pdfFile->getClientOriginalExtension();
        //         }
        //         $data->uploaded_at = now();
        //         $data->save();
        //     }
        //     $notification = array(
        //                 'message' => 'PDF/IMG Upload Successfully',
        //                 'alert-type' => 'success'
        //             );
            
        //          // return redirect()->back()->with('success', 'File uploaded successfully!');
        //             return redirect()->back()->with($notification); 

        // }


        // Validate the uploaded file
    //     $request->validate([
    //         'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048', // Adjust max size and allowed extensions as needed
    //     ]);

    //     // Get the student ID from the form input
    //     $studentId = $request->user_id;

    //     // Get the file from the request
    //     $file = $request->file('file');

    //     // Generate a unique file name to avoid overwriting existing files
    //     $fileName = time() . '_' . $file->getClientOriginalName();

    //     // Store the file on the server
    //     $file->storeAs('grade_reports', $fileName);

    //     // Save the file details to the database
    //     $gradeReport = new GradeReportCard();
    //     $gradeReport->student_id = $studentId;
    //     $gradeReport->teacher_id = auth()->user()->id;
    //     $gradeReport->file_path = $fileName;
    //     $gradeReport->file_type = $file->getClientOriginalExtension();
    //     $gradeReport->save();

    //     $notification = array(
    //         'message' => 'PDF/IMG Upload Successfully',
    //         'alert-type' => 'success'
    //     );

    //  // return redirect()->back()->with('success', 'File uploaded successfully!');
    //     return redirect()->back()->with($notification); 
    
    }


    // public function Download($id)
    // {
    //     $gradeReport = GradeReportCard::findOrFail($id);
    //     $filePath = storage_path('app/grade_reports/' . $gradeReport->file_path);

    //     return response()->download($filePath, $gradeReport->file_path);
    // }
//     public function Download($id)
// {
//     $report = GradeReportCard::findOrFail($id);

//     // Check if the PDF file exists
//     if ($report->pdf_file_path && Storage::exists('grade_reports_pdf/' . $report->pdf_file_path)) {
//         $pdfFilePath = public_path('upload/grade_reports_pdf' . $report->pdf_file_path); // Use public_path() to get the correct public directory path
//         $pdfFileName = 'custom_pdf_name.pdf';
//         return response()->download($pdfFilePath, $pdfFileName);
//     }

//     // Check if the image file exists
//     if ($report->image_file_path && Storage::exists('grade_reports_img/' . $report->image_file_path)) {
//         $imageFilePath = public_path('upload/grade_reports_img' . $report->image_file_path); // Use public_path() to get the correct public directory path
//         $imageFileName = 'custom_image_name.jpg'; // Provide a custom name for image file
//         return response()->download($imageFilePath, $imageFileName);
//     }

//     // If both file paths are empty or the files do not exist, redirect back with an error message
//     return redirect()->back()->with('error', 'File not found.');
// }

public function Img_Pdf_Edit(){
    $data['classes'] = StudentClass::all();
    return view('teacher.img_pdf.img_pdf_edit',$data);
}

public function Img_Pdf_Update(Request $request){

    $studentIds = $request->user_id;
    $pdfFiles = $request->file('pdf_file');
    $imageFiles = $request->file('image_file');

    for ($i = 0; $i < count($studentIds); $i++) {
        $studentId = $studentIds[$i];

        // Check if there is an existing GradeReportCard for the student
        // $existingReport = GradeReportCard::where('user_id', $studentId)->where('pdf_file_path',$pdfFiles)->where('image_file_path',$imageFiles)->first();
        $existingReport = GradeReportCard::where('user_id', $studentId)->first();

        // If an existing report is found, update the files
        if ($existingReport) {
            if (isset($pdfFiles[$i])) {
                // Process and validate the PDF file if provided
                $pdfValidator = Validator::make(['pdf_file' => $pdfFiles[$i]], [
                    'pdf_file' => 'required|mimes:pdf|max:5120', // Adjust max size and allowed extensions as needed
                ]);

                if ($pdfValidator->fails()) {
                    return back()->withErrors($pdfValidator->errors()->first('pdf_file'));
                }

                // Check if the actual file type is PDF
                if ($pdfFiles[$i]->getMimeType() != 'application/pdf') {
                    $notification = array(
                        'message' => 'Please upload a PDF file for the PDF field.',
                        'alert-type' => 'error'
                    );
                    return back()->withErrors($notification);
                }

                // Delete the existing PDF file
                $existingPdfFilePath = public_path('upload/grade_reports_pdf/' . $existingReport->pdf_file_path);
                if (file_exists($existingPdfFilePath)) {
                    unlink($existingPdfFilePath);
                }

                // Store and save the new PDF file
                $pdfFileName = date('Y-m-d') . '_pdf_' . $pdfFiles[$i]->getClientOriginalName();
                $uploadPath = public_path('upload/grade_reports_pdf');
                $pdfFiles[$i]->move($uploadPath, $pdfFileName);
                $existingReport->pdf_file_path = $pdfFileName;
                $existingReport->pdf_file_type = $pdfFiles[$i]->getClientOriginalExtension();
            }

            if (isset($imageFiles[$i])) {
                // Process and validate the image file if provided
                $imageValidator = Validator::make(['image_file' => $imageFiles[$i]], [
                    'image_file' => 'required|mimes:jpeg,jpg,png|max:5120', // Adjust max size and allowed extensions as needed
                ]);

                if ($imageValidator->fails()) {
                    return back()->withErrors($imageValidator->errors()->first('image_file'));
                }

                // Check if the actual file type is an image
                $allowedImageMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!in_array($imageFiles[$i]->getMimeType(), $allowedImageMimeTypes)) {
                    $notification = array(
                        'message' => 'Please upload an image file (JPEG, JPG, or PNG) for the image field.',
                        'alert-type' => 'error'
                    );
                    return back()->withErrors($notification);
                }

                // Delete the existing image file
                $existingImagePath = public_path('upload/grade_reports_img/' . $existingReport->image_file_path);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }

                // Store and save the new image file
                $imageFileName = date('Y-m-d') . '_img_' . $imageFiles[$i]->getClientOriginalName();
                $uploadPath = public_path('upload/grade_reports_img');
                $imageFiles[$i]->move($uploadPath, $imageFileName);
                $existingReport->image_file_path = $imageFileName;
                $existingReport->image_file_type = $imageFiles[$i]->getClientOriginalExtension();
            }

            // Update the timestamp
            $existingReport->uploaded_at = now();
            $existingReport->save();
        }
        // else {
        //     // If there is no existing report, create a new entry for the student
        //     $data = new GradeReportCard();
        //     $data->user_id = $studentId;

        //     if (isset($pdfFiles[$i])) {
        //         // Process and validate the PDF file if provided
        //         $pdfValidator = Validator::make(['pdf_file' => $pdfFiles[$i]], [
        //             'pdf_file' => 'required|mimes:pdf|max:5120', // Adjust max size and allowed extensions as needed
        //         ]);

        //         if ($pdfValidator->fails()) {
        //             return back()->withErrors($pdfValidator->errors()->first('pdf_file'));
        //         }

        //         // Check if the actual file type is PDF
        //         if ($pdfFiles[$i]->getMimeType() != 'application/pdf') {
        //             $notification = array(
        //                 'message' => 'Please upload a PDF file for the PDF field.',
        //                 'alert-type' => 'error'
        //             );
        //             return back()->withErrors($notification);
        //         }

        //         // Store and save the PDF file
        //         $pdfFileName = date('Y-m-d') . '_pdf_' . $pdfFiles[$i]->getClientOriginalName();
        //         $uploadPath = public_path('upload/grade_reports_pdf');
        //         $pdfFiles[$i]->move($uploadPath, $pdfFileName);
        //         $data->pdf_file_path = $pdfFileName;
        //         $data->pdf_file_type = $pdfFiles[$i]->getClientOriginalExtension();
        //     }

        //     if (isset($imageFiles[$i])) {
        //         // Process and validate the image file if provided
        //         $imageValidator = Validator::make(['image_file' => $imageFiles[$i]], [
        //             'image_file' => 'required|mimes:jpeg,jpg,png|max:5120', // Adjust max size and allowed extensions as needed
        //         ]);

        //         if ($imageValidator->fails()) {
        //             return back()->withErrors($imageValidator->errors()->first('image_file'));
        //         }

        //         // Check if the actual file type is an image
        //         $allowedImageMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        //         if (!in_array($imageFiles[$i]->getMimeType(), $allowedImageMimeTypes)) {
        //             $notification = array(
        //                 'message' => 'Please upload an image file (JPEG, JPG, or PNG) for the image field.',
        //                 'alert-type' => 'error'
        //             );
        //             return back()->withErrors($notification);
        //         }

        //         // Store and save the image file
        //         $imageFileName = date('Y-m-d') . '_img_' . $imageFiles[$i]->getClientOriginalName();
        //         $uploadPath = public_path('upload/grade_reports_img');
        //         $imageFiles[$i]->move($uploadPath, $imageFileName);
        //         $data->image_file_path = $imageFileName;
        //         $data->image_file_type = $imageFiles[$i]->getClientOriginalExtension();
        //     }

        //     $data->uploaded_at = now();
        //     $data->save();
        // }
    }

    $notification = array(
        'message' => 'Student Data Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

}

// public function IdPass(){
//     $userIds = GradeReportCard::pluck('user_id')->unique();
//     return view('teacher.body.sidebar', compact('userIds'));
// }

public function Img_Pdf_Delete(){

    $classes = StudentClass::all();
    $student = GradeReportCard::latest()->get();;
    return view('teacher.img_pdf.img_pdf_delete',compact('classes','student'));
//     $userId = $request->user_id;
// // Find the GradeReportCard record for the specified user
// $reportCard = GradeReportCard::where('user_id', $userId)->first();

// if ($reportCard) {
//     // Delete the PDF file if it exists
//     if ($reportCard->pdf_file_path) {
//         $pdfFilePath = public_path('upload/grade_reports_pdf/' . $reportCard->pdf_file_path);
//         if (file_exists($pdfFilePath)) {
//             unlink($pdfFilePath);
//         }
//     }

//     // Delete the image file if it exists
//     if ($reportCard->image_file_path) {
//         $imageFilePath = public_path('upload/grade_reports_img/' . $reportCard->image_file_path);
//         if (file_exists($imageFilePath)) {
//             unlink($imageFilePath);
//         }
//     }

//     // Delete the GradeReportCard record
//     $reportCard->delete();

//     // Return a JSON response indicating success
//     return response()->json(['message' => 'User deleted successfully'], 200);
// }

// Return a JSON response indicating that the user record was not found
// return response()->json(['message' => 'User record not found'], 404);


    
}


public function Img_Pdf_Real_Delete(Request $request,$user_id){
    
    try {
          // Get the specific student ID directly from the request
        // $studentId = $request->user_id;
        // $studentId = $request->input('user_id');

        // echo "Student ID: " . $studentId;
        // If you want to delete the PDF for a single student, access the first element of the array
        // $studentId = $studentIds[0];
         // Find the corresponding report card entry for the student
        $existingReport = GradeReportCard::where('user_id', $user_id)->first();

        if (!$existingReport) {
            // If the report card entry is not found, return an error response
            return response()->json(['error' => 'Report card not found for the specified student.'], 404);
        }
        
// Delete the PDF file
$pdfFilePath = public_path('upload/grade_reports_pdf/' . $existingReport->pdf_file_path);
if (file_exists($pdfFilePath)) {
    unlink($pdfFilePath);
}

// Delete the image file
$imageFilePath = public_path('upload/grade_reports_img/' . $existingReport->image_file_path);
if (file_exists($imageFilePath)) {
    unlink($imageFilePath);
}

// Delete the grade report card entry from the database
$existingReport->delete();

    
    // $notification = array(
    //     'message' => 'Deleted Successfully',
    //     'alert-type' => 'success'
    // );

    // return redirect()->back()->with($notification);
    return response()->json(['message' => 'Deleted successfully.'], 200);
} catch(\Exception $e) {
    return response()->json(['error' => 'Something went wrong.'], 500);
}
}



}
