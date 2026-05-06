<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Gate::define('access-admin-panel', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin', 'moderator']);
        });
    }
}
