<?php

namespace Devist\Laragin\Services;

use Closure;
use Devist\Laragin\Controllers\Controller;
use Devist\Laragin\Strategies\OTP;
use Devist\Laragin\Strategies\Password;
use Devist\Laragin\Strategies\Register;
use Illuminate\Support\Facades\Route;

class Bootstrap
{
    private static array $strategies = [
        'otp'      => OTP::class,
        'register' => Register::class,
        'password' => Password::class,
    ];

    public static function routes(): Closure
    {
        return function () {
            Route::prefix('{guard}')->group(function () {
                self::ِdefaultRoutes();

                foreach (config('laragin.strategies') as $strategy) {
                    self::resolve($strategy)::routes();
                }
            });
        };
    }

    private static function resolve(string $strategy): mixed
    {
        return self::$strategies[$strategy];
    }

    private static function ِdefaultRoutes(): void
    {
        Route::middleware('autoguard')->group(function () {
            Route::get('me', [Controller::class, 'index']);
            Route::get('logout', [Controller::class, 'delete']);
        });
    }
}
