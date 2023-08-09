<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignSubject;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use App\Models\Grade;
use App\Models\User; 
use App\Models\AssignStudent; 

class RetrieveSubjectController extends Controller
{
    public function GetSubject(Request $request){
    	$class_id = $request->class_id;
    	 $allData = AssignSubject::with(['school_subject'])->where('class_id',$class_id)->get();
		 
		// $allData = AssignSubject::with(['school_subject', 'grades' => function ($query) use ($class_id) {
		// 	$query->where('student_classes_id', $class_id);
		// }])->get();
	
		return response()->json($allData);
		
    }
    public function GetStudent(Request $request){
    	 $class_id = $request->class_id;
		 $subject = $request->subject;
    	$allData = AssignStudent::with(['student'])->where('class_id',$class_id)->get();
    	
		 $getStudent = Grade::with(['student'])->where('student_classes_id',$class_id)->where('subject',$subject)->get();

		 $responseData = [
			'allData' => $allData,
			'getStudent' => $getStudent,
		];
		
		return response()->json($responseData);
		//  return response()->json($allData);

// 		$class_id = $request->class_id;
// $assign_subject_id = $request->subject;

// $allData = AssignStudent::leftJoin('grades', function ($join) use ($class_id, $assign_subject_id) {
//         $join->on('assign_students.student_id', '=', 'grades.student_classes_id')
//             ->where('grades.student_classes_id', '=', $class_id)
//             ->where('grades.subject', '=', $assign_subject_id);
//     })
//     ->with(['student'])
//     ->where('assign_students.class_id', $class_id)
//     ->get();

// return response()->json($allData);

// $class_id = $request->class_id;
// $assign_subject_id = $request->subject;

// $allData = Grade::leftJoin('assign_students', function ($join) use ($class_id, $assign_subject_id) {
//         $join->on('assign_students.student_id', '=', 'grades.student_classes_id')
//             ->where('grades.student_classes_id', '=', $class_id)
//             ->where('grades.subject', '=', $assign_subject_id);
//     })
//     ->with(['student'])
//     ->where('assign_students.class_id', $class_id)
//     ->get();

// return response()->json($allData);



    }

}
