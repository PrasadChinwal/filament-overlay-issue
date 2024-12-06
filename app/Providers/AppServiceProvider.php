<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

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
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Gate::define('admin', function (User $user)
        {
            return $user->hasRole('admin');
        });

        Gate::define('super_admin', function (User $user)
        {
            return $user->hasRole('super_admin');
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->can('super_admin');
        });
    }
}
