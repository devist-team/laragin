<?php

namespace Devist\Laragin\Strategies;

use Devist\Laragin\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

class OTP extends Strategy
{
    static function routes(): void
    {
        Route::prefix('otp')->group(function () {
            Route::post('login', [OTPController::class, 'login']);
            Route::post('send', [OTPController::class, 'sendOtp']);
        });
    }
}
