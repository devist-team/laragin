<?php

namespace Devist\Laragin;

use Devist\Laragin\Core\Bootstrap;
use Devist\Laragin\Middlewares\Authenticate;
use Illuminate\Routing\Router;
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

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('autoguard', Authenticate::class);

        Route::prefix(config('laragin.prefix'))->group(Bootstrap::routes());

        Password::defaults(function () {

            return Password::min(8)->when($this->app->isProduction(), function ($password) {
                return $password->mixedCase()->uncompromised();
            });
        });
    }
}
