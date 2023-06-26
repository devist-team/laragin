<?php

namespace Devist\Laragin\Strategies;

use Devist\Laragin\Controllers\OTPController;
use Devist\Laragin\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

class Password extends Strategy
{
    static function routes(): void
    {
        Route::prefix('password')->group(function () {
            Route::post('login', [PasswordController::class, 'login']);
        });
    }
}
