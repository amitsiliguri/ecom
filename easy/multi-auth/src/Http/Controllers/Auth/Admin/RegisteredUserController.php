<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\RegisteredUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends RegisteredUser
{
    /**
     * Display the registration view.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $only = ['active','name', 'email', 'password', 'password_confirmation', 'terms'];
        return $this->register($request, $only,false,'admin', 'admin.users.index');
    }
}
