<?php

namespace App\Actions\Fortify;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    private UserService $userService;

    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'email' => ['required','string','email','max:255', 'unique:users'],
            'country_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'accept_terms' => ['required'],

            //'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        //$request = new Request();
        $request = new UserStoreRequest();
        $request->merge($input);

        $user = $this->userService->createUser($request);
        $user->setStatus('pending');

        session()->flash('success', __('auth.successfully_registered'));

        return $user;
    }
}
