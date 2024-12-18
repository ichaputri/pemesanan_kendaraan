<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            return $user->role == 'admin';
        });

        Gate::define('isDirektur', function($user) {
            return $user->role == 'direktur';
        });

        Gate::define('isManager', function($user) {
            return $user->role == 'manajer';
        });

        Gate::define('isPengelola', function($user) {
            return $user->role == 'pengelola';
        });

        Gate::define('isDriver', function($user) {
            return $user->role == 'driver';
        });
    }
}
