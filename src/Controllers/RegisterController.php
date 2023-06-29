<?php

namespace Devist\Laragin\Controllers;

use Devist\Laragin\Notifications\OTPNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    protected string $driver = 'register';

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $attributes = $request->validate([
            $this->identifier => ['required', 'string', 'max:20', Rule::unique($this->authenticatable)],
            'password'        => ['required', 'string', Password::defaults()],
        ]);

        $user = $this->authenticatable::create($attributes);

        $data['user'] = $user;

        if (config('laragin.drivers.register.login')) {
            $data['token'] = $user->createToken('laragin')->plainTextToken;
        }

        return response()->json($data, 200);
    }



}
