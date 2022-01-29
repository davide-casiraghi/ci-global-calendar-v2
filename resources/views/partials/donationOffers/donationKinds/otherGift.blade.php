<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
        <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_other_gift')</h3>
        <p class="text-gray-500 mb-2">
            @lang('donations.other_description')
        </p>
        <p class="text-gray-500 mb-2">
            @lang('donations.other_suggestion')
        </p>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_title'),
                    'name' => 'gift_title',
                    'placeholder' => '',
                    'value' => old('gift_title'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div class="mt-2">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_donater'),
                    'name' => 'gift_donater',
                    'placeholder' => '',
                    'value' => old('gift_donater'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div class="mt-2">
            @include('partials.forms.textarea', [
                   'label' => __('donations.gift_details'),
                   'name' => 'gift_description',
                   'placeholder' => '',
                   'value' => old('gift_description'),
                   'required' => false,
                   'disabled' => false,
                   'style' => 'tinymce',
               ])
        </div>

        <div class="mt-2">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_economic_value'),
                    'name' => 'gift_economic_value',
                    'placeholder' => '',
                    'value' => old('gift_economic_value'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div class="mt-2">
            @include('partials.forms.select', [
                'label' => __('donations.gift_country_of'),
                'name' => 'gift_country_of',
                'placeholder' => __('general.select_one'),
                'records' => $countries,
                'selected' =>  old('gift_country_of'),
                'required' => true,
                'extraClasses' => 'select2',
            ])
        </div>
    </div>
</div>