<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;
use Razorpay\Api\Api;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Api::class, function ($app) {
            return new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        });
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
