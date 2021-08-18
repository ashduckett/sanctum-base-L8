<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;

class UserController extends ApiController
{
    public function verify($token) {

        
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('The account has been verified successfully.');
    }

    public function resend(User $user) {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
            
            
        return $this->showMessage('The verification email has been resent');
    }
}
