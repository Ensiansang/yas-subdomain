<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class ManageUserController extends Controller
{
    public function UserView(){
        $data['allData'] = User::whereIn('role_id', [2, 3])
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->select('users.*', 'roles.name as role_name')
        ->get();
    
    return view('admin.user.view_user', $data);
    
    }


    public function UserAdd(){
		
    	return view('admin.user.add_user');
    }

	public function sendEmailVerificationNotifications()
{
    $users = User::whereNull('email_verified_at')->get();

    foreach ($users as $user) {
        $user->sendEmailVerificationNotification();
    }

    return 'Email verification notifications sent successfully.';
}
	public function UserStore(Request $request)
	{
		$validatedData = $request->validate([
			'email' => 'required|unique:users',
			'name' => 'required|unique:users',
			'role' => 'required|integer',
			'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add the image validation rules
		]);
	
		// Check if the email already exists in the database
		$existingEmail = User::where('email', $request->email)->first();
		if ($existingEmail) {
			$errors = [
				'email' => 'The email already exists in the database.',
			];
			return redirect()->back()->withInput()->withErrors($errors);
		}
	
		// Check if the username already exists in the database
		$existingUsername = User::where('name', $request->name)->first();
		if ($existingUsername) {
			$errors = [
				'name' => 'The username already exists in the database.',
			];
			return redirect()->back()->withInput()->withErrors($errors);
		}
	
		$data = new User();
		$data->name = $request->name;
		$data->email = $request->email;
		$data->password = bcrypt($request->password);
		$data->role_id = $request->role;
	
		if ($request->file('image')) {
			$file = $request->file('image');
			$filename = date('Y-m-d_H-i-s') . $file->getClientOriginalName();
	
			if ($request->role == 3) {
				$folderPath = 'upload/teacher_img'; // Folder path for teacher images
			} else {
				$folderPath = 'upload/student_img'; // Folder path for student images
			}
	
			$file->move(public_path($folderPath), $filename);
			$data->image = $filename;
		}
	
		$data->save();

	// Send email verification notification to the user
    $data->sendEmailVerificationNotification();
		$notification = [
			'message' => 'User Inserted Successfully',
			'alert-type' => 'success'
		];
	
		return redirect()->route('user.view')->with($notification);
	}
	




    public function UserEdit($id){
    	$editData = User::findOrFail($id);
    	return view('admin.user.edit_user',compact('editData'));

    }



    public function UserUpdate(Request $request, $id){

    	$data = User::findOrFail($id);
    	$data->name = $request->name;
    	$data->email = $request->email;
        $data->role_id = $request->role;
		$data->image = $request->image;
		if ($request->file('image')) {
			$file = $request->file('image');
			$filename = date('Y-m-d_H-i-s') . $file->getClientOriginalName();
	
			if ($request->role == 3) {
				$folderPath = 'upload/teacher_img'; // Folder path for teacher images
			} else {
				$folderPath = 'upload/student_img'; // Folder path for student images
			}
	
			$file->move(public_path($folderPath), $filename);
			$data->image = $filename;
		}
    	$data->save();

    	$notification = array(
    		'message' => 'User Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('user.view')->with($notification);

    }



    public function UserDelete($id){
    	$user = User::findOrFail($id);
    	$user->delete();

    	$notification = array(
    		'message' => 'User Deleted Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('user.view')->with($notification);

    }

	public function UserPassword($id){
		 $editPassword = User::findOrFail($id);
    	return view('admin.user.edit_password',compact('editPassword'));
	}
	public function UserPasswordUpdate(Request $request,$id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'new_password' => 'required|min:6', // Assuming minimum password length of 6 characters
    ]);

    // Find the user by their ID
     $user = User::findOrFail($id);

    // Update the user's password
    $user->password = Hash::make($validatedData['new_password']);
    $user->save();


	$notification = array(
		'message' => 'User Password Update Successfully',
		'alert-type' => 'success'
	);
    // Redirect or return a response as needed
    return redirect()->back()->with($notification);
}

}
