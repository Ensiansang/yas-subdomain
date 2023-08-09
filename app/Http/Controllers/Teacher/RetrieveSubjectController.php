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
	
    }

}
