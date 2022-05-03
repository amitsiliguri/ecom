<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Easy\MultiAuth\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Illuminate\View\View;

abstract class AuthenticatedSession extends Controller
{
    /**
     * Display the login view.
     *
     * @return Response|View
     */
    abstract public function create(): Response|View;

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    abstract public function store(LoginRequest $request): RedirectResponse;

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    abstract public function destroy(Request $request): RedirectResponse;

    /**
     * @param Request $request
     * @param string $guard
     * @param string $redirect
     * @return RedirectResponse
     */
    protected function logOut(Request $request, string $guard = 'web', string $redirect = 'front'): RedirectResponse
    {
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route($redirect);
    }

    /**
     * @param LoginRequest $request
     * @param string $guard
     * @param string $redirect
     * @param array $check
     * @return RedirectResponse
     * @throws ValidationException
     */
    protected function logIn(LoginRequest $request, string $guard = 'web', string $redirect = RouteServiceProvider::HOME, array $check = []): RedirectResponse
    {
        $defaultCheck = $request->only('email','password');
        $check = array_merge($check, $defaultCheck);
        $request->authenticate($check, $guard);
        $request->session()->regenerate();
        return redirect()->intended($redirect);
    }
}
