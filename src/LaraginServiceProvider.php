<?php

namespace Devist\Laragin;

use Devist\Laragin\Core\Bootstrap;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class LaraginServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laragin.php', 'laragin');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laragin.php' => config_path('laragin.php'),
            ], 'laragin-config');

            $this->publishes([
                __DIR__.'/../resources/views/otp/email.blade.php' => resource_path('views/laragin/otp/email.blade.php'),
            ], 'laragin-templates');
        }

        Route::prefix(config('laragin.prefix'))->group(Bootstrap::routes());

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule->mixedCase()->uncompromised()
                : $rule;
        });
    }
}
