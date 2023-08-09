<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function AdminProfileView(){
    	
        $id = Auth::user()->id;
        $user = User::with('role')->find($id);
        $roleName = $user->role->name;
    
        return view('admin.adminprofile.view_profile', compact('user', 'roleName'));

    }


    public function AdminProfileEdit(){
    	$id = Auth::user()->id;
    	$editData = User::findOrFail($id);
    	return view('admin.adminprofile.edit_profile',compact('editData'));
    }


    public function AdminProfileStore(Request $request){

    	$data = User::find(Auth::user()->id);
    	$data->name = $request->name;
    	$data->email = $request->email;

    	if ($request->file('image')) {
    		$file = $request->file('image');
    		@unlink(public_path('upload/admin_img/'.$data->image));
    		$filename = date('Y-m-d_H-i-s').$file->getClientOriginalName();
    		$file->move(public_path('upload/admin_img'),$filename);
    		$data['image'] = $filename;
    	}
    	$data->save();

    	$notification = array(
    		'message' => 'Admin Profile Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('profile.view')->with($notification);

    } // End Method 


 
 	public function AdminPasswordView(){
 		return view('admin.adminprofile.edit_password');
 	}



 	public function AdminPasswordUpdate(Request $request){
 		$validatedData = $request->validate([
    		'oldpassword' => 'required',
    		'password' => 'required|confirmed',
    	]);


    	$hashedPassword = Auth::user()->password;
    	if (Hash::check($request->oldpassword,$hashedPassword)) {
    		$user = User::find(Auth::id());
    		$user->password = Hash::make($request->password);
    		$user->save();
		
			$notification = array(
				'message' => 'Admin Password Change Updated Successfully',
				'alert-type' => 'success'
			);
    		
			return redirect()->back()->with($notification);
		} else {
			$errors = [
				'oldpassword' => 'Incorrect current password. Please try again.',
			];
	
			return redirect()->back()->withErrors($errors);
		}
    	


 	} // End Method 

}
