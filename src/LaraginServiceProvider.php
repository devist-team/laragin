<?php

namespace Devist\laragin;

use Illuminate\Support\ServiceProvider;

class LaraginServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laragin.php', 'laragin');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laragin.php' => config_path('laragin.php'),
            ], 'laragin');
        }


    }
}
