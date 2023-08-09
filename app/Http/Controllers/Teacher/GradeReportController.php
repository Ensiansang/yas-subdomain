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
     // Validate if both PDF and image files are uploaded for all selected students
    foreach ($studentIds as $key => $studentId) {
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
                if (isset($pdfFiles[$i])) {
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
    
                // Store and save the PDF file with a flag to identify it as a PDF file
                $pdfFileName = date('Y-m-d') . '_pdf_' . $pdfFiles[$i]->getClientOriginalName();
                $uploadPath = public_path('upload/grade_reports_pdf');
                $pdfFiles[$i]->move($uploadPath, $pdfFileName);
                $data->pdf_file_path  = $pdfFileName;
                $data->pdf_file_type = $pdfFiles[$i]->getClientOriginalExtension();
            }
    
            // Process and validate the image file if provided
                if (isset($imageFiles[$i])) {
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
    }

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
        
    }

    $notification = array(
        'message' => 'Student Data Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

}

public function Img_Pdf_Delete(){

    $classes = StudentClass::all();
    $student = GradeReportCard::latest()->get();;
    return view('teacher.img_pdf.img_pdf_delete',compact('classes','student')); 
}


public function Img_Pdf_Real_Delete(Request $request,$user_id){
    
    try {
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
    return response()->json(['message' => 'Deleted successfully.'], 200);
} catch(\Exception $e) {
    return response()->json(['error' => 'Something went wrong.'], 500);
}
}



}
