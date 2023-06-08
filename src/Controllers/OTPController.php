<?php

namespace Devist\Laragin\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OTPController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20'],
        ]);

        $user = Auth::guard()->getProvider()->retrieveByCredentials([
            $this->identifier => $attributes[$this->identifier],
        ]);

        if ( ! $user) {
            throw ValidationException::withMessages([$this->identifier => 'The User is not existed']);
        }

        $cachedOtp = Cache::get($user->id.'_otp');

        if ( ! $cachedOtp || $cachedOtp != $request->input('otp')) {
            return response()->json(['error' => 'Invalid OTP code'], 401);
        }

        Cache::forget($user->id.'_otp');

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}
