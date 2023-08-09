<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\StudentClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AssignSubjectController;
use App\Http\Controllers\Admin\StudentRegController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\GradeDisplayController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\MarkController;
use App\Http\Controllers\Teacher\RetrieveSubjectController;
use App\Http\Controllers\Teacher\GradeReportController;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\ErrorController;
use App\Http\Middleware\RedirectIfAuthenticated;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   return view('login');
});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
// Route::middleware(['auth'])->group(function() {
//  Route::get('/404', [ErrorController::class, 'handle404'])->name('error.404');

// });

// Route::get('/404', [ErrorController::class, 'handle404'])->name('error.404');

// Route::get('/404', 'ErrorController@handle404')->name('error.404');
// Other routes...

// Route::fallback([ErrorController::class, 'handle404'])->name('error.404');

 Route::group(['middleware' => 'prevent-back-history'],function(){

// Admin Login ->middleware(RedirectIfAuthenticated::class)
Route::get('admin/login', [AdminController::class, 'AdminLogin']);
Route::post('admin/login', [AdminController::class, 'Addminlogin'])->name('addminlogin');

//Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

 Route::middleware(['auth', 'role:1'])->group(function() {
   Route::controller(AdminController::class)->group(function(){
    Route::get('admin/dashboard','AdminDashboard')->name('admin.dashboard');
    Route::get('admin/logout','AdminLogout')->name('admin.logout');
   });
   // Route::prefix('user')->group(function() {
   Route::controller(ManageUserController::class)->group(function(){
    Route::get('admin/user/view', 'UserView')->name('user.view');
    Route::get('admin/user/add', 'UserAdd')->name('user.add');
    Route::post('admin/user/store', 'UserStore')->name('user.store');
    Route::get('admin/user/edit/{id}', 'UserEdit')->name('user.edit');
    Route::post('admin/user/update/{id}','UserUpdate')->name('user.update');
    Route::get('admin/user/delete/{id}', 'UserDelete')->name('user.delete');
    Route::get('admin/user/password/{id}', 'UserPassword')->name('user.password');
    Route::post('admin/user/password/update/{id}','UserPasswordUpdate')->name('user.password.update');
   // });
   });
   Route::controller(AdminProfileController::class)->group(function(){
      Route::get('admin/profile/view', 'AdminProfileView')->name('profile.view');
      Route::get('admin/profile/edit', 'AdminProfileEdit')->name('profile.edit');

      Route::post('store','AdminProfileStore')->name('profile.store');
      Route::get('admin/password/view', 'AdminPasswordView')->name('password.view');
      Route::post('admin/password/update','AdminPasswordUpdate')->name('password.update');
   });
   Route::controller(StudentClassController::class)->group(function(){
      Route::get('student/class/view', 'StudentClassView')->name('student.class.view');
      Route::get('student/class/add', 'StudentClassAdd')->name('student.class.add');

      Route::post('student/class/store','StudentClassStore')->name('student.class.store');
      Route::get('student/class/edit/{id}', 'StudentClassEdit')->name('student.class.edit');
      Route::get('student/class/delete/{id}', 'StudentClassDelete')->name('student.class.delete');
      Route::post('student/class/update/{id}','StudentClassUpdate')->name('student.class.update');
   });
   Route::controller(SubjectController::class)->group(function(){
      Route::get('school/subject/view', 'SchoolSubjectView')->name('school.subject.view');
      Route::get('school/subject/add', 'SchoolSubjectAdd')->name('school.subject.add');

      Route::post('school/subject/store','SchoolSubjectStore')->name('school.subject.store');
      Route::get('school/subject/edit/{id}', 'SchoolSubjectEdit')->name('school.subject.edit');
      Route::get('school/subject/delete/{id}', 'SchoolSubjectDelete')->name('school.subject.delete');
      Route::post('school/subject/update/{id}','SchoolSubjectUpdate')->name('school.subject.update');
   });

   Route::controller(AssignSubjectController::class)->group(function(){
      Route::get('assign/subject/view', 'AssignSubjectView')->name('assign.subject.view');
      Route::get('assign/subject/add', 'AssignSubjectAdd')->name('assign.subject.add');

      Route::post('assign/subject/store','AssignSubjectStore')->name('assign.subject.store');
      Route::get('assign/subject/edit/{class_id}', 'AssignSubjectEdit')->name('assign.subject.edit');
      Route::post('assign/subject/update/{class_id}','AssignSubjectUpdate')->name('assign.subject.update');
      Route::get('assign/subject/details/{class_id}','DetailsAssignSubject')->name('assign.subject.details');
   });

   Route::controller(StudentRegController::class)->group(function(){
      Route::get('student/reg/view', 'StudentRegView')->name('student.reg.view');
      Route::get('student/reg/add', 'StudentRegAdd')->name('student.reg.add');
      Route::get('student/class/get', 'StudentClassGet')->name('student.class.get');
      Route::get('student/reg/edit/{student_id}','StudentRegEdit')->name('student.reg.edit');
      Route::post('student/reg/store','StudentRegStore')->name('student.reg.store');
      Route::post('student/reg/update/{student_id}','StudentRegUpdate')->name('student.reg.update');
      Route::get('/search-students', 'search'); 
   });

  
   
 });

// User Manage From Admin Panel



// Student/Teacher Login 
Route::get('/login', [LoginController::class, 'Login'])->name('login');
Route::middleware('guest')->post('/login', [LoginController::class, 'stutechlogin'])->name('stutechlogin');

Route::middleware(['auth', 'role:2' , 'verified'])->group(function() {
   Route::controller(StudentController::class)->group(function(){
    Route::get('student/dashboard', 'StudentDashboard')->name('student.dashboard');
    Route::get('student/logout', 'StudentLogout')->name('student.logout');
    Route::get('student/download-grade-report/{id}/{type}', 'Download')->name('student.download.grade.report');
 });
});

 Route::middleware(['auth', 'role:3' , 'verified' ])->group(function() {
   Route::controller(TeacherController::class)->group(function(){
    Route::get('teacher/dashboard', 'TeacherDashboard')->name('teacher.dashboard');
    Route::get('teacher/logout', 'TeacherLogout')->name('teacher.logout');
 });
   Route::controller(MarkController::class)->group(function(){
      Route::get('teacher/mark/add', 'MarkAdd')->name('mark.add');
      Route::post('teacher/mark/store', 'MarkStore')->name('mark.store');
      Route::get('teacher/mark/edit', 'MarkEdit')->name('mark.edit');
      Route::post('teacher/mark/update', 'MarkUpdate')->name('mark.update');
      Route::get('teacher/mark/getstudents', 'MarkEditGetStudent')->name('mark.getstudents');
 });
   Route::controller(RetrieveSubjectController::class)->group(function(){
      Route::get('marks/getsubject',  'GetSubject')->name('marks.getsubject');
      Route::get('student/marks/getstudent', 'GetStudent')->name('student.marks.getstudent');
 });
   Route::controller(GradeReportController::class)->group(function(){
      Route::get('img/pdf/getstudent', 'ImgPdfStudent')->name('img.pdf.getstudent');
      Route::get('teacher-img/pdf-add', 'Img_Pdf_Add')->name('img.pdf.add');
      Route::post('/upload-grade-report',  'Upload')->name('upload.grade.report');
      Route::get('teacher-img/pdf-edit', 'Img_Pdf_Edit')->name('img.pdf.edit');
      Route::post('teacher-img/pdf-update','Img_Pdf_Update')->name('img.pdf.update');
      Route::get('teacher-img/pdf-delete', 'Img_Pdf_Delete')->name('img.pdf.delete');
      Route::delete('teacher-img/pdf-real-delete/{user_id}', 'Img_Pdf_Real_Delete')->name('img.pdf.real.delete');
      // Route::get('teacher/get/id','IdPass')->name('teacher.get.id');
});
});
 });