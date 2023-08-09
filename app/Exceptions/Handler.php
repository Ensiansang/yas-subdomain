<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\Store;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;



class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
    //         if (Auth::check()) {
    //            // $role = Auth::user()->role_id;
                
    //             // Log the role ID
    //             $role = Auth::user()->role->name; // Assuming the role table has a 'name' column
    //             return response()->view('errors.404', ['role' => $role], 404);
    //         }
    //     }
    
    //     return parent::render($request, $exception);
    // }
    
//     public function render($request, Throwable $exception)
// {
//     if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
//         if (Auth::check()) {
//             $id = Auth::user()->id;
//             $user = User::with('role')->find($id);
            
//             if ($user) {
//                 $role = $user->role->name; // Assuming the role table has a 'name' column
//                 return view('errors.404', ['role' => $role]);
//             }
//         }
//     }
    
//     return parent::render($request, $exception);
// }



    // /**
    //  * Render an exception into an HTTP response.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Exception  $exception
    //  * @return \Symfony\Component\HttpFoundation\Response
    //  *
    //  * @throws \Exception
    //  */
    // public function render($request, Throwable $exception)
    // {
    //     if ($this->isHttpException($exception)) {
    //         $statusCode = $exception->getStatusCode();

    //         if ($statusCode === 404) {
    //             // Manually authenticate the user
    //         auth()->onceUsingId(3); 


    //             // Get the authenticated user (if any)
    //             $user = auth()->user();

    //     //         // Set the message session variable based on the user's role
    //     //         // if ($user) {
    //     //         //     if ($user->role_id == 1) {
    //     //         //         session(['message' => 'Back to student dashboard']);
    //     //         //     } elseif ($user->role_id == 2) {
    //     //         //         session(['message' => 'Back to teacher dashboard']);
    //     //         //     } elseif ($user->role_id == 3) {
    //     //         //         session(['message' => 'Back to admin dashboard']);
    //     //         //     }
    //     //         // } else {
    //     //         //     session(['message' => 'Back to login']);
    //     //         // }
    //             if ($user) {
    //                 if ($user->role_id == 1) {
    //                     session(['message' => 'Back to student dashboard']);
    //                     return redirect('/student/dashboard');
    //                 } elseif ($user->role_id == 2) {
    //                     session(['message' => 'Back to teacher dashboard']);
    //                     return redirect('/teacher/dashboard');
    //                 } elseif ($user->role_id == 3) {
    //                     session(['message' => 'Back to admin dashboard']);
    //                     return redirect('/admin/dashboard');
    //                 }
    //             } else {
    //                 session(['message' => 'Back to login']);
    //                 return redirect('/login');
    //             }
    //         }
    //     }

    //     return parent::render($request, $exception);
    //     // if ($exception instanceof NotFoundHttpException) {
    //     //     $user = Auth::user();
    
    //     //     if ($user) {
    //     //         if ($user->role_id == 1) {
    //     //             // Redirect the student user back to the student dashboard
    //     //             return redirect('/student/dashboard')->with('message', 'Back to student dashboard');
    //     //         } elseif ($user->role_id == 2) {
    //     //             // Redirect the teacher user back to the teacher dashboard
    //     //             return redirect('/teacher/dashboard')->with('message', 'Back to teacher dashboard');
    //     //         } elseif ($user->role_id == 3) {
    //     //             // Redirect the admin user back to the admin dashboard
    //     //             return redirect('/admin/dashboard')->with('message', 'Back to admin dashboard');
    //     //         }
    //     //     }
    
    //     //     // Redirect unauthenticated users to the login page
    //     //     return redirect('/login')->with('message', 'Back to login');
    //     // }
    
    //     // return parent::render($request, $exception);
    // }

    
}
