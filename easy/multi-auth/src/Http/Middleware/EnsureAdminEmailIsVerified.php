<?php

namespace Easy\MultiAuth\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;

class EnsureAdminEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $redirectToRoute
     * @return Response|RedirectResponse|JsonResponse|null
     */
    public function handle(Request $request, Closure $next, string $redirectToRoute = null): Response|RedirectResponse|JsonResponse|null
    {
        if (!$request->user('admin') ||  ($request->user('admin') instanceof MustVerifyEmail &&  ! $request->user('admin')->hasVerifiedEmail())) {
            return $request->expectsJson() ? abort(403, 'Your email address is not verified.') : Redirect::guest(URL::route($redirectToRoute ?: 'admin.verification.notice'));
        }
        return $next($request);
    }
}
