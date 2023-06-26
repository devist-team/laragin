<?php

namespace Devist\Laragin\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    public mixed $authenticatable;
    public string $identifier;
    public string|null $guard;

    protected string $driver;

    public function __construct(Request $request)
    {
        $this->guard           = $request->route('guard');
        $model                 = config('auth.guards.'.$this->guard.'.provider');
        $this->authenticatable = config('auth.providers.'.$model.'.model');

        if (isset($this->driver)) {
            $this->identifier = config('laragin.drivers.'.$this->driver.'.identifier');
        }
    }

    public function index()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }

    public function delete(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['user' => $request->user()], 200);
    }
}
