<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('nav' , function () {
            return include base_path('data/nav.php');
        });
        $this->app->bind('abilities' , function () {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::before(function ($user) {
            return $user->super_admin == 1? true : null;
        });

        Gate::define('reports.view', function ($user) {
            return ($user->roles->where('role_name','reports.view')->first() == null) ? false : true;
        });

    }
}
