<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class EmailVerificationNotification extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    abstract public function store(Request $request): RedirectResponse;

    /**
     * @param Request $request
     * @param string $guard
     * @param string $redirect
     * @return RedirectResponse
     */
    protected function process(Request $request, string $guard = 'web', string $redirect = RouteServiceProvider::HOME): RedirectResponse
    {
        if ($request->user($guard)->hasVerifiedEmail()) {
            return redirect()->intended($redirect);
        }

        $request->user($guard)->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
