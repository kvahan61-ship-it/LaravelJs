<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Category;             // 🛑 ԱՎԵԼԱՑՐԵԼ ԵՆՔ ՍԱ
use Illuminate\Support\Facades\View; // 🛑 ԱՎԵԼԱՑՐԵԼ ԵՆՔ ՍԱ
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
        \Illuminate\Support\Facades\Gate::define('access-admin-panel', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin', 'moderator']);
        });

        \Illuminate\Support\Facades\View::composer('categories/index', function ($view) {
            if (\Schema::hasTable('categories')) {
                $view->with('categories', \App\Models\Category::all());
            }
        });
    }
}
