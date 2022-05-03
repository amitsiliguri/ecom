<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\AuthenticatedSession;
use Easy\MultiAuth\Http\Requests\Auth\LoginRequest;
use Easy\MultiAuth\MultiAuthServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends AuthenticatedSession
{

    /**
     * Display the login view.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('admin.password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $check = ['active' => 1];
        return $this->logIn($request, 'admin', MultiAuthServiceProvider::ADMIN_HOME, $check);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        return $this->logOut($request, 'admin', 'admin.login');
    }
}
