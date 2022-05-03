<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use Easy\MultiAuth\Service\Register as RegisterUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Illuminate\View\View;

abstract class UpdateUser extends Controller
{
    /**
     * @var RegisterUser
     */
    private RegisterUser $registerUser;

    /**
     * @param RegisterUser $registerUser
     */
    public function __construct(
        RegisterUser $registerUser
    ) {
        $this->registerUser = $registerUser;
    }

    /**
     * Display the registration view.
     *
     * @param int $id
     * @return Response|View
     */
    abstract public function edit(int $id): Response|View;

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    abstract public function update(Request $request, int $id): RedirectResponse;

    /**
     * @param int $id
     * @param Request $request
     * @param bool $self
     * @param string $guard
     * @param string $redirectRoute
     * @return mixed
     * @throws ValidationException
     */
    protected function updateExisting(
        int     $id,
        Request $request,
        bool    $self = true,
        string  $guard = 'web',
        string  $redirectRoute = 'dashboard'
    ): mixed
    {
        return $this->registerUser->updateUser($id, $request->only([
            'active',
            'name',
            'email',
            'password',
            'password_confirmation',
            'terms'
        ]), $guard);
    }
}
