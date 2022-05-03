<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\PasswordResetLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends PasswordResetLink
{
    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->process($request, 'Easy\MultiAuth\Models\Admin', 'admins');
    }
}
