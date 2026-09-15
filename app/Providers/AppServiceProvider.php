<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Force HTTPS in production to prevent Mixed Content errors
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share global settings to all views
        if (!app()->runningInConsole() && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            view()->share('settings', $settings);
        }

        // Register View Composer for Activity Stream
        if (!app()->runningInConsole() && \Illuminate\Support\Facades\Schema::hasTable('posts')) {
            view()->composer('layouts.partials.topbar', 'App\Http\ViewComposers\ActivityStreamComposer');
        }
    }
}
