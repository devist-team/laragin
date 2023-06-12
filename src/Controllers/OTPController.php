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
            'otp'             => ['required', 'string', 'digits:'.config('laragin.drivers.otp.digits')],
        ]);

        $user = Auth::guard()->getProvider()->retrieveByCredentials([
            $this->identifier => $attributes[$this->identifier],
        ]);

        if ( ! $user) {
            throw ValidationException::withMessages([$this->identifier => 'The User is not existed']);
        }

        $cachedOtp = Cache::get($user->id.'_otp');

        if ( ! $cachedOtp || $cachedOtp != $request->input('otp')) {
            throw ValidationException::withMessages(['otp' => 'Invalid otp']);
        }

        Cache::forget($user->id.'_otp');

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function sendOtp(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20'],
        ]);

        $user = Auth::guard()->getProvider()->retrieveByCredentials([
            $this->identifier => $attributes[$this->identifier],
        ]);

        if ( ! $user) {
            $user = $this->authenticatable::create($attributes);
        }

        $otp = mt_rand(
            10 ** (config('laragin.drivers.otp.digits') - 1),
            10 ** config('laragin.drivers.otp.digits') - 1
        );

        Cache::put($user->id.'_otp', $otp, config('laragin.drivers.otp.expire_in'));

        return response()->json(['message' => $otp.' OTP has been sent to your email'.$user->id], 200);
    }
}
