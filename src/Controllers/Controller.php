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

    public function __construct(Request $request)
    {
        $this->authenticatable =  config('auth.providers.'.$request->route('guard').'.model');
        $this->identifier = config('laragin.drivers.otp.identifier');
    }

    public function index()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
