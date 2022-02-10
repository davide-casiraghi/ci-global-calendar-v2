<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * The captcha should match with the one stored in the session.
 */
class CaptchaSessionMatch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(session()->has('captcha')) {
            return session()->get('captcha') === $value;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The captcha value doesn\'t match.';
    }
}
