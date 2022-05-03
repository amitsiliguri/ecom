<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Easy\MultiAuth\MultiAuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\EmailVerificationNotification;


class EmailVerificationNotificationController extends EmailVerificationNotification
{
    /**
     * Send a new email verification notification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->process($request, 'admin', MultiAuthServiceProvider::ADMIN_HOME);
    }
}
