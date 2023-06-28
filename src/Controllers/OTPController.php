<?php

namespace Devist\Laragin\Controllers;

use Devist\Laragin\Notifications\OTPNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class OTPController extends Controller
{

    protected string $driver = 'otp';

    public function check(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20'],
        ]);

        $user = Auth::guard($this->guard)->getProvider()->retrieveByCredentials([
            $this->identifier => $attributes[$this->identifier],
        ]);

        return response()->json(['is_registered' => (bool)$user], 200);
    }


    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    public function sendOtp(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20'],
            'channel'         => ['sometimes', 'string'],
        ]);

        $user = Auth::guard($this->guard)->getProvider()->retrieveByCredentials([
            $this->identifier => $attributes[$this->identifier],
        ]);

        if ( ! $user) {
            $user = $this->authenticatable::create($attributes);
        } elseif (Cache::Driver(config('laragin.cache'))->has($user->id.'_otp')) {
            return $this->otpResponse(Cache::Driver(config('laragin.cache'))->get($user->id.'_otp'));
        }

        $otp = random_int(
            10 ** (config('laragin.drivers.otp.digits') - 1),
            10 ** config('laragin.drivers.otp.digits') - 1
        );

        Cache::Driver(config('laragin.cache'))->put($user->id.'_otp', $otp, config('laragin.drivers.otp.expire_in'));
        Notification::send($user, new OTPNotification($otp, $attributes['channel'] ?? ''));


        return $this->otpResponse($otp);
    }

    private function otpResponse(string $otp)
    {
        $data = ['message' => ' OTP has been sent to your email'];

        if (config('laragin.expose')) {
            $data['otp'] = $otp;
        }

        return response()->json($data, 200);
    }

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
            throw ValidationException::withMessages([$this->identifier => trans('auth.failed')]);
        }

        $cachedOtp = Cache::Driver(config('laragin.cache'))->get($user->id.'_otp');

        if ( ! $cachedOtp || $cachedOtp !== $request->input('otp')) {
            throw ValidationException::withMessages(['otp' => trans('auth.failed')]);
        }

        Cache::Driver(config('laragin.cache'))->forget($user->id.'_otp');

        $token = $user->createToken('laragin')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
