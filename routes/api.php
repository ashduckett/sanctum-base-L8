<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// This route will allow you to get hold of a user based on the username and password
// and I consider this logging in.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// This route will allow you to register a user.
Route::post('register', [AuthController::class, 'register']);
// namespace App\Http\Controllers\User
Route::name('verify')->get('users/verify/{token}', 'App\Http\Controllers\User\UserController@verify');
