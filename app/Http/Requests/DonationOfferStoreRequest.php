<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DonationOfferStoreRequest extends FormRequest
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
            'surname' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'string'],
            'email' => ['required','string','email','max:255'],
            'language_spoken' => ['required', 'string', 'max:255'],
            //'offer_kind' => ['offer_kind', 'string'],
            'volunteer_kind' => Rule::requiredIf($this->offer_kind == 'volunteer'),
            'volunteer_description' => Rule::requiredIf($this->offer_kind == 'volunteer'),
            'gift_title' => Rule::requiredIf(
                $this->offer_kind == 'free_entrance' ||
                $this->offer_kind == 'other_gift'
            ),
            'gift_donater' => Rule::requiredIf(
                $this->offer_kind == 'free_entrance' ||
                $this->offer_kind == 'other_gift'
            ),
            'gift_description' => Rule::requiredIf(
                $this->offer_kind == 'free_entrance' ||
                $this->offer_kind == 'other_gift'
            ),
            'gift_economic_value' => Rule::requiredIf(
                $this->offer_kind == 'free_entrance' ||
                $this->offer_kind == 'other_gift'
            ),
            'gift_country_of' => Rule::requiredIf(
                $this->offer_kind == 'free_entrance' ||
                $this->offer_kind == 'other_gift'
            ),
            'gift_kind' => Rule::requiredIf($this->offer_kind == 'free_entrance'),
        ];
    }
}
