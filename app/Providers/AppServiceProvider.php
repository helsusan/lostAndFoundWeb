<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-report', function(User $user){
            return $user->role_id == 2;
        });

        Gate::define('verify-report', function(User $user){
            return $user->role_id == 1;
        });

        Gate::define('create-item', function(User $user){
            return $user->role_id == 1;
        });
        
        Gate::define('create-location', function(User $user){
            return $user->role_id == 1;
        });
    }
}