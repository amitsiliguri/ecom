<?php

namespace Easy\MultiAuth\Http\Controllers\Auth;

use Easy\MultiAuth\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\AuthenticatedSession;

class AuthenticatedSessionController extends AuthenticatedSession
{
    /**
     * Display the login view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        return $this->logIn($request);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        return $this->logOut($request);
    }
}
