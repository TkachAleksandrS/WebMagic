<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SortServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sort', function () {
            return new \App\Helpers\Sort\Sort;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
