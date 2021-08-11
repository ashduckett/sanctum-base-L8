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
        $this->renderable(function(ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, 422);
        });

        $this->renderable(function(AuthenticationException $e) {
            // $errors = $e->validator->errors()->getMessages();
            // return $this->errorResponse($errors, 422);
            return $this->errorResponse('Unauthenticated', 401);
        });
    
        // if ($exception instanceof AuthenticationException) {
        //     return $this->unauthenticated($request, $exception);
        // }

    }
}
