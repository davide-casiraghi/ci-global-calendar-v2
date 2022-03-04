<form class="mb-10" method="get" action="#dataarea">
    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <div class="font-bold text-white">@lang('homepage-search.what')</div>
            @include('partials.forms.select', [
                            'label' => "",
                            'name' => 'event_category_id',
                            'placeholder' => __('views.select_category'),
                            'records' => $eventCategories,
                            'optionShowsField' => 'name',
                            'selected' => old('event_category_id', $searchParameters['event_category_id']),
                            'required' => TRUE,
                            'extraClasses' => 'select2',
                        ])

            <div class="mt-4">
                <div class="font-bold text-white">@lang('homepage-search.who')</div>
                @include('partials.forms.select', [
                                'label' => "",
                                'name' => 'teacher_id',
                                'placeholder' => __('homepage-search.teacher_name'),
                                'records' => $teachers,
                                'optionShowsField' => 'full_name',
                                'selected' => old('teacher_id', $searchParameters['teacher_id']),
                                'required' => TRUE,
                                'extraClasses' => 'select2',
                            ])
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0">
            <div class="font-bold text-white">
                @lang('homepage-search.where')
                <svg x-data x-tooltip="{{__('homepage-search.where_tooltip')}}" @click="$tooltip('{{__('homepage-search.where_tooltip')}}')"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="flex-shrink-0 mr-1.5 h-4 w-4 inline text-white ml-1">
                    <path fill="currentColor" d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/>
                </svg>
            </div>
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
            <div class="font-bold text-white">
                @lang('homepage-search.when')
                <svg x-data x-tooltip="{{__('homepage-search.when_tooltip')}}" @click="$tooltip('{{__('homepage-search.when_tooltip')}}')"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="flex-shrink-0 mr-1.5 h-4 w-4 inline text-white ml-1">
                    <path fill="currentColor" d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S224 177.7 224 160C224 142.3 238.3 128 256 128zM296 384h-80C202.8 384 192 373.3 192 360s10.75-24 24-24h16v-64H224c-13.25 0-24-10.75-24-24S210.8 224 224 224h32c13.25 0 24 10.75 24 24v88h16c13.25 0 24 10.75 24 24S309.3 384 296 384z"/>
                </svg>
            </div>

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