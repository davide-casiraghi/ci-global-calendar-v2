<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;

class RegisteredUserController extends \Laravel\Fortify\Http\Controllers\RegisteredUserController
{
    /**
     * Disable auto login after registration in laravel 8.
     * https://stackoverflow.com/questions/64397645/how-can-i-disable-auto-login-after-registration-in-laravel-8
     *
     * @param  Request  $request
     * @param  CreatesNewUsers  $creator
     * @return RegisterResponse
     */
    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        event(new Registered($user = $creator->create($request->all())));
        return app(RegisterResponse::class);
    }

}