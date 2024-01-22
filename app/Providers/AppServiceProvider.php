<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;

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
        // You can replace 'your.route.name' with the actual name of your route
        View::composer(['admin.partials.applicationTableOrder'], function ($view) {
            if (\Route::currentRouteName() == 'application.index') {
                // Include the template file for the specific route
                $view->with('includeOffset', true);
            }
        });

        // You can replace 'your.route.name' with the actual name of your route
        View::composer(['admin.partials.applicationFilter'], function ($view) {
            if (\Route::currentRouteName() == 'application.index') {
                // Include the template file for the specific route
                $view->with('includeOffset', true);
            }
        });
    }
}
