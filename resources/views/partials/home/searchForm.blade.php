<form class="mb-10" method="get" action="#dataarea">
    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <div class="font-bold text-white">@lang('homepage-search.what')</div>
            @include('partials.forms.select', [
                            'label' => "",
                            'name' => 'event_category_id',
                            'placeholder' => __('views.select_category'),
                            'records' => $eventCategories,
                            'selected' => old('event_category_id', $searchParameters['event_category_id']),
                            'required' => TRUE,
                            'extraClasses' => '',
                        ])

            <div class="mt-4">
                <div class="font-bold text-white">@lang('homepage-search.who')</div>
                @include('partials.forms.select', [
                                'label' => "",
                                'name' => 'teacher_id',
                                'placeholder' => __('homepage-search.teacher_name'),
                                'records' => $teachers,
                                'selected' => old('teacher_id', $searchParameters['teacher_id']),
                                'required' => TRUE,
                                'extraClasses' => '',
                            ])
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0">
            <div class="font-bold text-white">@lang('homepage-search.where')</div>
            @livewire('continent-country-region', [
                'selectedContinent' => old('continent_id', $searchParameters['continent_id']),
                'selectedCountry' => old('country_id', $searchParameters['country_id']),
                'selectedRegion' => old('region_id', $searchParameters['region_id']),
            ])

            <div class="mt-4">
                @include('partials.forms.input', [
                        'label' => '',
                        'name' => 'city_name',
                        'placeholder' => __('homepage-search.search_by_city'),
                        'value' => old('city_name', $searchParameters['city_name']),
                        'required' => false,
                        'disabled' => false,
                ])
            </div>

            <div class="mt-4">
                @include('partials.forms.input', [
                        'label' => '',
                        'name' => 'venue_name',
                        'placeholder' => __('homepage-search.venue_name'),
                        'value' => old('venue_name', $searchParameters['venue_name']),
                        'required' => false,
                        'disabled' => false,
                ])
            </div>

        </div>
        <div class="md:col-span-2 mt-5 md:mt-0">
            <div class="font-bold text-white">@lang('homepage-search.when')</div>

            @include('partials.forms.inputFlatPickrDatePicker', [
                            'class' => 'flatpickr date future',
                            'label' => "",
                            'placeholder' => __('homepage-search.start_on'),
                            'name' => 'start_repeat',
                            'value' => old('start_repeat', $searchParameters['start_repeat']),
                            'required' => true,
                            'disabled' => false,
                        ])

            <div class="mt-4">
                @include('partials.forms.inputFlatPickrDatePicker', [
                            'class' => 'flatpickr date future',
                            'label' => "",
                            'placeholder' => __('homepage-search.end_on'),
                            'name' => 'end_repeat',
                            'value' => old('end_repeat', $searchParameters['end_repeat']),
                            'required' => true,
                            'disabled' => false,
                        ])
            </div>
        </div>
    </div>

    {{-- Search / Reset buttons --}}
    <div class="flex justify-end mt-4">

        <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
            @lang('general.search')
        </button>

        <a href="{{ route('home') }}" target="_self" class="grayButton mediumButton">
            @lang('general.reset')
        </a>
    </div>
</form>