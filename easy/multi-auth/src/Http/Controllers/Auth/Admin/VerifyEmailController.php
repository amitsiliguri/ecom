<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Easy\MultiAuth\MultiAuthServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user('admin')->hasVerifiedEmail()) {
            return redirect()->intended(MultiAuthServiceProvider::ADMIN_HOME.'?verified=1');
        }

        if ($request->user('admin')->markEmailAsVerified()) {
            event(new Verified($request->user('admin')));
        }

        return redirect()->intended(MultiAuthServiceProvider::ADMIN_HOME.'?verified=1');
    }
}
