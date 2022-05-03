<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Abstracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Inertia\Response;

abstract class PasswordResetLink extends Controller
{
    /**
     * @return Response|View
     */
    abstract public function create(): Response|View;

    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    abstract public function store(Request $request): RedirectResponse;

    /**
     * @param Request $request
     * @param string $model
     * @param string $broker
     * @return RedirectResponse
     * @throws ValidationException
     */
    protected function process(Request $request, string $model = 'App\Model\User', string $broker = 'users'): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:' . $model . ',email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::broker($broker)->sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
