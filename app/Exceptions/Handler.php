<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    // public function render($request, Exception $exception) {
    //     // var_dump('Function hit');
    //     return response()->json(['shit' => false], 401);
    // }

    // protected function unauthenticated($request, AuthenticationException $exception) {
    //     // var_dump('GOT HERE');
    //     return response()->json(['status' => false], 401);
    // }
    
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        
        // Handle issues with validation
        // This one is actually working and also fires when the
        // user details are wrong! It's not an authentication error that fires!
        $this->renderable(function(ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, 422);
        });
        
        // This gets hit if you try to access /user when not logged in.
        $this->renderable(function(AuthenticationException $e) {
            // $errors = $e->validator->errors()->getMessages();
            // return $this->errorResponse($errors, 422);
            
            return $this->errorResponse('Unauthenticated', 401);
        });
    }
}
