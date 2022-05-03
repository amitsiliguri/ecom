<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Easy\MultiAuth\MultiAuthServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request): Response|RedirectResponse
    {
        return $request->user('admin')->hasVerifiedEmail()
                    ? redirect()->intended(MultiAuthServiceProvider::ADMIN_HOME)
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
