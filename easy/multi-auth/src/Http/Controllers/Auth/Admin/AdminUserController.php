<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Easy\MultiAuth\Models\Admin;

class AdminUserController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Auth/List', [
            'admins' => Admin::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
