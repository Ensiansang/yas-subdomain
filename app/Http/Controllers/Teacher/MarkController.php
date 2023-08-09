<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SchoolSubject;
use App\Models\StudentClass; 
use App\Models\AssignSubject;
use App\Models\Grade;

class MarkController extends Controller
{
    public function MarkAdd(){
    	$data['classes'] = StudentClass::all();
    	
  	return view('teacher.mark.mark_add',$data);
    }    

public function MarkStore(Request $request)
{
    $studentcount = $request->user_id;
    if ($studentcount) {
        for ($i = 0; $i < count($request->user_id); $i++) {
            $data = new Grade();
            $data->student_classes_id = $request->student_classes_id;
            $data->subject = $request->subject;
            $data->user_id = $request->user_id[$i];

            $grade = $request->grade[$i];
            // if (strlen($grade) > 3) {
            //     $grade = substr($grade, 0, 3);
            // }
            $data->grade = $grade;

            $data->date_uploaded = now();

            // Server-side validation
            $validator = Validator::make(['grade' => $grade], [
                'grade' => 'required|numeric|max:100',
            ]);

            $validator->setAttributeNames(['grade' => 'Grade']); // Customize the attribute name for error messages

            if ($validator->fails()) {
                $notification = array(
                    'message' => $validator->errors()->first('grade'),
                    'alert-type' => 'error'
                );
                // return redirect()->back()->withErrors($validator)->with($notification);
                return back()->withErrors($validator)->with($notification);
            }

            $data->save();
        }
    }

    $notification = array(
        'message' => 'Student Marks Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
}

public function MarkEdit(){
  $data['classes'] = StudentClass::all();

  return view('teacher.mark.mark_edit',$data);
}

public function MarkEditGetStudent(Request $request){
  $class_id = $request->student_classes_id;
  $assign_subject_id = $request->subject;
  
  $getStudent = Grade::with(['student'])->where('student_classes_id',$class_id)->where('subject',$assign_subject_id)->get();
  
  return response()->json($getStudent);

}

public function MarkUpdate(Request $request){

    $studentIds = $request->user_id;

    // Create an array to store the validation rules
    $rules = [];
   // Loop through the submitted student IDs again
    foreach ($studentIds as $index => $studentId) {
        // Find the existing grade record for the student
        $grade = Grade::where('student_classes_id', $request->student_classes_id)
            ->where('subject', $request->subject)
            ->where('user_id', $studentId)
            ->first();
// Validate the grade for each student
$validator = Validator::make(['grade' => $request->grade[$index]], [
    'grade' => 'required|numeric|max:100',
]);

$validator->setAttributeNames(['grade' => 'Grade for Student ' . ($index + 1)]);

if ($validator->fails()) {
    $notification = [
        'message' => $validator->errors()->first('grade'),
        'alert-type' => 'error'
    ];
    return back()->withErrors($validator)->with($notification);
}
        // If the grade record exists, update it
        if ($grade) {
            $grade->update([
                'grade' => $request->grade[$index],
                'date_uploaded' => now()
            ]);
        } 
    }

    $notification = [
        'message' => 'Student Marks Updated Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);



    } // end marks


}
