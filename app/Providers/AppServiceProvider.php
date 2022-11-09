<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Upmind\ProvisionBase\Registry\Registry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('provision-registry', Registry::class);
    }
}
