<?php

namespace Devist\Laragin\Core;

use Closure;
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
            foreach (config('laragin.strategies') as $strategy) {
                self::resolve($strategy)::routes();
            }
        };
    }

    private static function resolve(string $strategy)
    {
        return self::$strategies[$strategy];
    }
}
