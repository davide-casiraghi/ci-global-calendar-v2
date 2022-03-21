<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VenueStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'country_id' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'zipcode' => ['nullable', 'string'],
            'extra_info' => ['nullable', 'string'],
            'website' => ['nullable', 'url'],
        ];
    }
}
