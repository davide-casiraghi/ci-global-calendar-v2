<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
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
        $maxYear = Carbon::now()->year;

        $rules = [
            'country_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'year_starting_practice' => ['required', 'integer','min:1972','max:' . ($maxYear)],
            'year_starting_teach' => ['required', 'integer','min:1972','max:' . ($maxYear)],
            'significant_teachers' => ['required', 'string'],
            'facebook' => ['nullable', 'url'],
            'website' => ['nullable', 'url'],
        ];

        if (request()->hasFile('profile_picture')) {
            $rules['profile_picture'] = ['nullable', 'image','mimes:jpg,jpeg,png','max:5120']; // 5MB
        }

        return $rules;
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'facebook.url' => 'The facebook link is invalid. It should start with https://',
            'website.url' => 'The website link is invalid. It should start with https://',
            'profile_picture.max' => 'The maximum image size is 5MB. If you need to resize it you can use: www.simpleimageresizer.com',
        ];
    }


}
