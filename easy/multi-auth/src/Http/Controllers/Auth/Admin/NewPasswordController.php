<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\NewPassword;

class NewPasswordController extends NewPassword
{
    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->process($request, 'admins', 'admin.login');
    }
}
