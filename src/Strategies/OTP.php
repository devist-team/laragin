<?php

namespace Devist\Laragin\Strategies;

use Devist\Laragin\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

class OTP
{
    static function routes(): void
    {
        Route::prefix('{guard}')->group(function () {
            Route::prefix('otp')->group(function () {
                Route::middleware('auth:sanctum')->get('me', [OTPController::class, 'index']);
                Route::post('login', [OTPController::class, 'login']);
                Route::post('send', [OTPController::class, 'sendOtp']);
            });
        });
    }
}