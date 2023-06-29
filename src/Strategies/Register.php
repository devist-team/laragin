<?php

namespace Devist\Laragin\Strategies;

use Devist\Laragin\Controllers\OTPController;
use Devist\Laragin\Controllers\PasswordController;
use Devist\Laragin\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

class Register extends Strategy
{
    static function routes(): void
    {
        Route::prefix('register')->group(function () {
            Route::post('/', [RegisterController::class, 'register']);
        });
    }
}
