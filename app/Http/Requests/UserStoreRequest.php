<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'string'],
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($this->id)], // Defined as hidden input in the user edit view.
            'description' => ['required', 'string', 'min:90'],
            'accept_terms' => ['required'],
        ];

        if ($this->getMethod() == 'POST') { //store
            $rules += ['password' => 'required|min:6|confirmed'];
        } else { // update
            $rules += ['password' => 'nullable|min:6|confirmed'];
        }

        return $rules;
    }
}
