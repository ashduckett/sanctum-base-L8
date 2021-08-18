<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function($user) {
            
            retry(5, function() use ($user) {
                // var_dump($user);
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function($user) {
            retry(5, function() use ($user) {

                if ($user->isDirty('email')) {
                    Mail::to($user)->send(new UserMailChanged($user));
                }
            }, 100);
        });
    }
}
