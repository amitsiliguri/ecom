<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Easy\MultiAuth\MultiAuthServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\ConfirmablePassword;

class ConfirmablePasswordController extends ConfirmablePassword
{
    /**
     * Show the confirm password view.
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Confirm the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->save($request, 'admin', MultiAuthServiceProvider::ADMIN_HOME);
    }
}
