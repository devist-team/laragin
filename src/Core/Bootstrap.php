<?php

namespace Devist\Laragin\Core;

use Closure;
use Devist\Laragin\Controllers\Controller;
use Devist\Laragin\Strategies\OTP;
use Illuminate\Support\Facades\Route;

class Bootstrap
{
    private static array $strategies = [
        'otp' => OTP::class,
    ];

    public static function routes(): Closure
    {
        return function () {
            self::ِdefaultRoutes();

            Route::prefix('{guard}')->group(function () {
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
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', [Controller::class, 'index']);
            Route::get('logout', [Controller::class, 'delete']);
        });
    }
}
