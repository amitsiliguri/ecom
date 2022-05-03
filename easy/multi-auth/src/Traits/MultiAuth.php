<?php

namespace Easy\MultiAuth\Traits;

use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

trait MultiAuth
{
    public function logOut($request, $guard = 'web', $redirect = 'front')
    {
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route($redirect);
    }

    public function logIn($request, $guard = 'web', $redirect = RouteServiceProvider::HOME)
    {
        $request->authenticate($guard);
        $request->session()->regenerate();
        return redirect()->intended($redirect);
    }
}
