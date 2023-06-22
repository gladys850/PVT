<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\LoanTracking;
use Illuminate\Support\Facades\Schema;
use App\Observers\LoanTrackingObserver;

class LoanTrackingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::connection('platform')->hasTable('records')) LoanTracking::observe(LoanTrackingObserver::class);
    }
}
