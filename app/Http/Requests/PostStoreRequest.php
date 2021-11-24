<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'intro_text' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'featured' => ['nullable'],
            'before_content' => ['nullable', 'string'],
            'after_content' => ['nullable', 'string'],
        ];

        if (request()->hasFile('introimage')) {
            $rules['introimage'] = ['nullable', 'image','mimes:jpg,jpeg,png','max:5120']; // 5MB
        }

        return $rules;
    }
}
