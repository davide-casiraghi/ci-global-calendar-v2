<div class="md:grid md:grid-cols-3 md:gap-6">

    {{-- Donation kind title --}}
    <div class="md:col-span-1">
        <div x-show="selectedDK == 'financial'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_financial')</h3>
        </div>
        <div x-show="selectedDK == 'free_entrance'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_free_entrance')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.gift_kind_free_festival')
            </p>
        </div>
        <div x-show="selectedDK == 'volunteer'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_volunteer')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.volunteering_thank_you')
            </p>
            <p class="text-gray-500 mb-2">
                @lang('donations.volunteering_details') <br>
            </p>
        </div>
        <div x-show="selectedDK == 'other_gift'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_other_gift')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.other_description')
            </p>
            <p class="text-gray-500 mb-2">
            @lang('donations.other_suggestion')
        </div>
    </div>

    {{-- Donation kind form inputs --}}
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div x-show="selectedDK == 'financial'">
            <p class="text-gray-500 mb-2">
                @lang('donations.financial_contribution_description')
            </p>
            <a href="/posts/donate" class="" target="_blank">@lang('menu.donate') ></a>
        </div>

        <div x-show="['free_entrance','other_gift'].includes(selectedDK)"
             class="">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_title'),
                    'name' => 'gift_title',
                    'placeholder' => '',
                    'value' => old('gift_title'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div x-show="selectedDK == 'free_entrance'" class="mt-2">
            @include('partials.forms.select', [
                'label' => __('donations.entrance_kind'),
                'name' => 'gift_kind',
                'placeholder' => __('general.select_one'),
                'records' => $giftKinds,
                'selected' =>  old('gift_kind'),
                'required' => true,
                'extraClasses' => 'select2',
            ])
        </div>

        <div x-show="['free_entrance','other_gift'].includes(selectedDK)"
             class="mt-2">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_donater'),
                    'name' => 'gift_donater',
                    'placeholder' => '',
                    'value' => old('gift_donater'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div x-show="['free_entrance','other_gift'].includes(selectedDK)"
             class="mt-2">
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

        <div x-show="['free_entrance','other_gift'].includes(selectedDK)"
             class="mt-2">
            @include('partials.forms.input', [
                    'label' => __('donations.gift_economic_value'),
                    'name' => 'gift_economic_value',
                    'placeholder' => '',
                    'value' => old('gift_economic_value'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div x-show="['free_entrance','other_gift'].includes(selectedDK)"
             class="mt-2">
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

        <div x-show="selectedDK == 'volunteer'">
            <h4 class="text-lg font-medium leading-6 text-gray-900 mb-2">@lang('donations.volunteering_looking_for')</h4>
            <ul>
                <li class="flex mb-2">
                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="hand-point-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-green-800">
                        <path fill="currentColor" d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                    </svg>
                    <div class="ml-2">
                        @lang('donations.volunteering_kind_developers')
                    </div>
                </li>
                <li class="flex mb-2">
                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="hand-point-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-green-800">
                        <path fill="currentColor" d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                    </svg>
                    <div class="ml-3">
                        @lang('donations.volunteering_kind_fundrisers')
                    </div>
                </li>
                <li class="flex mb-2">
                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="hand-point-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-green-800">
                        <path fill="currentColor" d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                    </svg>
                    <div class="ml-3">
                        @lang('donations.volunteering_kind_translators')
                    </div>
                </li>
                <li class="flex mb-1">
                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="hand-point-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-green-800">
                        <path fill="currentColor" d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                    </svg>
                    <div class="ml-3">
                        @lang('donations.volunteering_kind_communicators')
                    </div>
                </li>
                <li class="flex">
                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="hand-point-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-green-800">
                        <path fill="currentColor" d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                    </svg>
                    <div class="ml-3">
                        @lang('donations.volunteering_kind_others')
                    </div>
                </li>
            </ul>

            <div class="mt-4">
                <div class="">
                    @include('partials.forms.select', [
                        'label' => __('donations.volunteering_apply_for'),
                        'name' => 'volunteer_kind',
                        'placeholder' => __('general.select_one'),
                        'records' => $volunteerKinds,
                        'selected' =>  old('volunteer_kind'),
                        'required' => true,
                        'extraClasses' => 'select2',
                    ])
                </div>

                <div class="mt-2">
                    @include('partials.forms.textarea', [
                           'label' => __('donations.volunteering_details_request'),
                           'name' => 'volunteer_description',
                           'placeholder' => '',
                           'value' => old('volunteer_description'),
                           'required' => false,
                           'disabled' => false,
                           'style' => 'tinymce',
                       ])
                </div>
            </div>
        </div>

    </div>
</div>
