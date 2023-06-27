<?php

namespace Devist\Laragin\Controllers;

use Devist\Laragin\Notifications\OTPNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Symfony\Component\Translation\t;

class PasswordController extends Controller
{

    protected string $driver = 'password';

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20'],
            'password'        => ['required', 'string'],
        ]);

        $loggedIn = Auth::guard($this->guard)->once($attributes);


        if ( ! $loggedIn) {
            throw ValidationException::withMessages([$this->identifier => trans('auth.failed')]);
        }

        $token = Auth::guard($this->guard)->user()->createToken('laragin')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function update(Request $request)
    {
        $rules['new_password'] = ['required', 'string', Password::defaults()];
        if (
            config('laragin.drivers.password.restricted_update') and
            ! is_null(Auth::user()->getAuthPassword())
        ) {
            $rules['current_password'] = ['required', 'string', 'current_password:'.$this->guard];
        }

        $attributes = $request->validate($rules);

        $user = Auth::guard($this->guard)->user();

        $user->update([
            'password' => Hash::make($attributes['new_password']),
        ]);

        return response()->json($user, 200);
    }
}
