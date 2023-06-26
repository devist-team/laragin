<?php

namespace Devist\Laragin\Middlewares;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        return app()->make(BaseAuthenticate::class)->handle($request, $next, $request->route('guard'));
    }
}
