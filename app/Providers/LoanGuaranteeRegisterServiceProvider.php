<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\LoanGuaranteeRegister;
use App\Observers\LoanGuaranteeRegisterObserver;
use Illuminate\Support\Facades\Schema;

class LoanGuaranteeRegisterServiceProvider extends ServiceProvider
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
        if (Schema::connection('platform')->hasTable('loan_guarantee_registers')) LoanGuaranteeRegister::observe(LoanGuaranteeRegisterObserver::class);
    }
}
