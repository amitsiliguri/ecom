<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Illuminate\View\View;

abstract class ConfirmablePassword extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return Response|View
     */
    abstract public function show(): Response|View;


    /**
     * Confirm the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    abstract public function store(Request $request): RedirectResponse;

    /**
     * @param Request $request
     * @param string $guard
     * @param string $redirect
     * @return RedirectResponse
     * @throws ValidationException
     */
    protected function save(Request $request, string $guard = 'web', string $redirect = RouteServiceProvider::HOME): RedirectResponse
    {
        if (! Auth::guard($guard)->validate([
            'email' => $request->user($guard)->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended($redirect);
    }
}
