<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentClass;

class StudentClassController extends Controller
{
    public function StudentClassView(){
        $data['allData'] = StudentClass::all();
    	return view('admin.student_class.view_class',$data);
    }
    public function StudentClassAdd(){
    	return view('admin.student_class.add_class');
    }

    public function StudentClassStore(Request $request){

    	$validatedData = $request->validate([
    		'name' => 'required|unique:student_classes,name',
    		
    	]);

    	$data = new StudentClass();
    	$data->name = $request->name;
    	$data->save();

    	$notification = array(
    		'message' => 'Student Class Inserted Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('student.class.view')->with($notification);

    }

    public function StudentClassEdit($id){
    	$editData = StudentClass::findOrFail($id);
    	return view('admin.student_class.edit_class',compact('editData'));

    }


    public function StudentClassUpdate(Request $request,$id){

		$data = StudentClass::findOrFail($id);
     
     $validatedData = $request->validate([
    		'name' => 'required|unique:student_classes,name,'.$data->id
    		
    	]);

    	
    	$data->name = $request->name;
    	$data->save();

    	$notification = array(
    		'message' => 'Student Class Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('student.class.view')->with($notification);
    }


    public function StudentClassDelete($id){
    	$user = StudentClass::findOrFail($id);
    	$user->delete();

    	$notification = array(
    		'message' => 'Student Class Deleted Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('student.class.view')->with($notification);

    }
}
