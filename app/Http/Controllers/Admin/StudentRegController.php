<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\StudentClass;
use DB;


class StudentRegController extends Controller
{
    public function StudentRegView(){
    	
    	$data['classes'] = StudentClass::all();
    	$data['class_id'] = StudentClass::orderBy('id','desc')->first()->id;
    	// dd($data['class_id']);
    	$data['allData'] = AssignStudent::where('class_id',$data['class_id'])->get();
    	return view('admin.student_reg.student_view',$data);

    }

    public function StudentRegAdd(){
    	$data['classes'] = StudentClass::all();
        $data['students'] = User::where('role_id', 2)->get();
    	return view('admin.student_reg.student_add',$data);
    }

    public function StudentRegStore(Request $request){
        $studentId = $request->student;
        $classId = $request->class_id;

    // Check if the student is already assigned to the class
    // $existingAssignment = AssignStudent::where('student_id', $studentId)
    //     ->where('class_id', $classId)
    //     ->first();
    $existingAssignment = AssignStudent::where('student_id', $studentId)->first();

    if ($existingAssignment) {
        $notification = array(
            'message' => 'Student is already assigned to this class.',
            'alert-type' => 'error'
        );
        
        return redirect()->back()->with($notification);
    }
    	DB::transaction(function() use($request){
    	$student = User::where('role_id', 2)->orderBy('id','DESC')->first();

          $assign_student = new AssignStudent();
          $assign_student->student_id = $request->student;
          $assign_student->class_id = $request->class_id;
          $assign_student->save();

    	});


    	$notification = array(
    		'message' => 'Student Registration Inserted Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('student.reg.view')->with($notification);

    } // End Method 


    public function StudentClassGet(Request $request){
     	$data['classes'] = StudentClass::all();

    	$data['class_id'] = $request->class_id;
    	 
    	$data['allData'] = AssignStudent::where('class_id',$request->class_id)->get();
    	return view('admin.student_reg.student_view',$data);

    } 

    public function StudentRegEdit($student_id){
    	$data['classes'] = StudentClass::all();

    	$data['editData'] = AssignStudent::with(['student'])->where('student_id',$student_id)->first();
    	// dd($data['editData']->toArray());
    	return view('admin.student_reg.student_edit',$data);

    }

    // public function SearchStudents(Request $request) {
    //     $name = $request->input('name');
    //     $students = User::where('role_id', 2)
    //                     ->where('name', 'like', '%' . $name . '%')
    //                     ->get(['id', 'name']);
    
    //     return response()->json($students);
    // }
    public function search(Request $request)
    {
        $searchQuery = $request->input('name');
        
        // Query the database for matching student records with role_id equal to 2
    $students = User::where('name', 'LIKE', '%'.$searchQuery.'%')
    ->where('role_id', 2)
    ->get();
        
        return response()->json(['students' => $students]);
    }
    
    public function StudentRegUpdate(Request $request, $student_id){
        DB::transaction(function() use($request,$student_id){
            
        $assign_student = AssignStudent::where('id',$request->id)->where('student_id',$student_id)->first();
    
          $assign_student->class_id = $request->class_id;
          $assign_student->save();

        });

            $notification = array(
                'message' => 'Student Registration Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('student.reg.view')->with($notification);


    }

}
