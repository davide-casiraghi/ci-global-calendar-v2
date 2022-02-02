<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse
{
    /**
     * Redirect the admin users to the dashboard after login,
     * and all the other users the homepage.
     *
     * Override toResponse() of Laravel\Fortify\Contracts\LoginResponse.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->intended('/dashboard');
        }
        return redirect()->intended('/');
    }
}