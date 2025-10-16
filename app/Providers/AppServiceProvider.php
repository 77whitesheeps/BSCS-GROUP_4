<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

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
        // Set the application timezone
        $timezone = 'Asia/Singapore';
        date_default_timezone_set($timezone);
        Carbon::setLocale('en');
        
        // Ensure Carbon uses the correct timezone
        Carbon::setTestNow(null);

        // Use Bootstrap 5 pagination views across the app
        Paginator::useBootstrapFive();
    }
}
