<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventStoreRequest extends FormRequest
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
            'event_category_id' => ['required'],
            'venue_id' => ['required'],
            'teacher_ids' => ['nullable', 'array'],
            'organizer_ids' => ['nullable', 'array'],
            'description' => ['required', 'string'],
            'startDate' => ['required', 'string'],
            'endDate' => ['required', 'string'],
            //'startDateAndTime' => ['required', 'string'],
            //'endDateAndTime' => ['required', 'string'],
            'repeat_weekly_on' => [Rule::requiredIf(request()->repeat_type == 2), 'array'],
            'on_monthly_kind' => [Rule::requiredIf(request()->repeat_type == 3)],
            'repeat_until' => [Rule::requiredIf(request()->repeat_type == 2 || request()->repeat_type == 3)],
            'contact_email' => ['nullable', 'email'],
            'facebook_event_link' => ['nullable', 'url'],
            'website_event_link' => ['nullable', 'url'],
        ];

        if (request()->hasFile('introimage')) {
            $rules['introimage'] = ['nullable', 'image','mimes:jpg,jpeg,png','max:5120']; // 5MB
        }

        return $rules;
    }


    /**
     * Attach a sometimes() rule by overriding the getValidatorInstance() function
     * in your form request.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidatorInstance(): Validator
    {
        $validator = parent::getValidatorInstance();

        // End date and start date must match if the event is repetitive
        $validator->sometimes('endDate', 'same:startDate', function ($input) {
            return $input->repeat_type > 1;
        });

        return $validator;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'repeat_weekly_on[].required' => 'Please specify which day of the week is repeting the event.',
            'on_monthly_kind.required' => 'Please specify the kind of monthly repetition',
            'endDate.same' => 'If the event is repetitive the start date and end date must match',
            'facebook_event_link.url' => 'The facebook link is invalid. It should start with https://',
            'website_event_link.url' => 'The website link is invalid. It should start with https://',
            'introimage.max' => 'The maximum image size is 5MB. If you need to resize it you can use: www.simpleimageresizer.com',
        ];
    }
}