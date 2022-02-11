<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BackgroundImageStoreRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'photographer' => ['nullable', 'string', 'max:255'],
            'orientation' => ['required', 'string'],
        ];
    }
}
