<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSubject;

class SubjectController extends Controller
{
    public function SchoolSubjectView(){
        $data['allData'] = SchoolSubject::all();
    	return view('admin.school_subject.view_school_subject',$data);
    }

    public function SchoolSubjectAdd(){
    	return view('admin.school_subject.add_school_subject');
    }

    public function SchoolSubjectStore(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:school_subjects,name',
            
        ]);

        $data = new SchoolSubject();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Subject Inserted Successfully',
            'alert-type' => 'success'
        );

    return redirect()->route('school.subject.view')->with($notification);

    }


    public function SchoolSubjectEdit($id){
        $editData = SchoolSubject::find($id);
        return view('admin.school_subject.edit_school_subject',compact('editData'));
    }



    public function SchoolSubjectUpdate(Request $request,$id){

 $data = SchoolSubject::find($id);
 
 $validatedData = $request->validate([
        'name' => 'required|unique:school_subjects,name,'.$data->id
        
    ]);

    
    $data->name = $request->name;
    $data->save();

    $notification = array(
        'message' => 'Subject Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('school.subject.view')->with($notification);
}


 public function SchoolSubjectDelete($id){
        $user = SchoolSubject::find($id);
        $user->delete();

        $notification = array(
            'message' => 'Subject Deleted Successfully',
            'alert-type' => 'success'
        );

   return redirect()->route('school.subject.view')->with($notification);

    }

}
