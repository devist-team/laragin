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

    protected string $driver;

    public function __construct(Request $request)
    {
        $guard                 = $request->route('guard');
        $model                 = config('auth.guards.'.$guard.'.provider');
        $this->authenticatable = config('auth.providers.'.$model.'.model');
        $this->identifier      = config('laragin.drivers.'.$this->driver.'.identifier');
    }

    public function index()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }
}
