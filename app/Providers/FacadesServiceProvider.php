<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Permission\Permission;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('permission', function($app){
            return new Permission($app);
        });
    }
}
