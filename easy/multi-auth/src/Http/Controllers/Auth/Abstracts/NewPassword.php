<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Inertia\Response;
use Illuminate\Validation\Rules;

abstract class NewPassword extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return Response|View
     */
    abstract public function create(Request $request): Response|View;

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
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
    protected function process(Request $request, string $guard = 'web', string $redirect = 'login'): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise, we will parse the error and return the response.
        $status = Password::broker($guard)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route($redirect)->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
