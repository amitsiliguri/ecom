<?php

namespace Easy\MultiAuth\Http\Controllers\Auth\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Easy\MultiAuth\Models\Admin;
use Easy\MultiAuth\Http\Controllers\Auth\Abstracts\UpdateUser;

class AdminUserUpdateController extends UpdateUser
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        return Inertia::render('Auth/Edit',[
                'admin.user' => Admin::findOrFail($id)
            ]
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->updateExisting($id, $request,'false', 'admin');
        return redirect()->route('admin.users.index')->with('success', 'Admin User successfully Updated');
    }
}
