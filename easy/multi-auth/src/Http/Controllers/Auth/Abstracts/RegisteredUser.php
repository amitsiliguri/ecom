<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Easy\MultiAuth\Service\Register as RegisterUser;
use Illuminate\View\View;

abstract class RegisteredUser extends Controller
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
     * @return Response|View
     */
    abstract public function create(): Response|View;

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     */
    abstract public function store(Request $request): RedirectResponse;

    /**
     * @param Request $request
     * @param array $columns
     * @param bool $self
     * @param string $guard
     * @param string $redirectRoute
     * @return Redirector|Application|RedirectResponse
     * @throws ValidationException
     */
    protected function register(
        Request $request,
        array $columns = ['name', 'email', 'password', 'password_confirmation', 'terms'],
        bool $self = true,
        string $guard = 'web',
        string $redirectRoute = 'dashboard',
    ): Redirector|Application|RedirectResponse {
        $registeredUser = $this->registerUser->createUser($request->only($columns), $guard);
        event(new Registered($registeredUser));
        if ($self) {
            Auth::guard($guard)->login($registeredUser);
        }
        return redirect()->route($redirectRoute)->with('success', 'Registered successfully');
    }
}
