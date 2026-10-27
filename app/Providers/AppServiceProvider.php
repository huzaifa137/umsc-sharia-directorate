<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Locale is now handled by SetLocale middleware to ensure it runs after the session middleware.

        // Allows views to write @can_permission('nikah.create') ... @endcan_permission
        // as a concise wrapper around App\Services\AccessControl::can().
        Blade::if('can_permission', function (string $slug) {
            return \App\Services\AccessControl::can($slug);
        });

        Blade::if('full_access', function () {
            return \App\Services\AccessControl::hasFullAccess();
        });
    }
}
