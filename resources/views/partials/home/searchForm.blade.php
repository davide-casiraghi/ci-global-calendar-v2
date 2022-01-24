<form class="mb-10" method="get" action="#dataarea">
    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <div class="font-bold text-white">What</div>
            @include('partials.forms.select', [
                            'label' => "",
                            'name' => 'eventCategoryId',
                            'placeholder' => __('views.select_category'),
                            'records' => $eventCategories,
                            'selected' => old('eventCategoryId', $searchParameters['eventCategoryId']),
                            'required' => TRUE,
                            'extraClasses' => '',
                        ])

            <div class="mt-4">
                <div class="font-bold text-white">Who</div>
                @include('partials.forms.select', [
                                'label' => "",
                                'name' => 'teacherId',
                                'placeholder' => __('homepage-search.teacher_name'),
                                'records' => $teachers,
                                'selected' => old('teacherId', $searchParameters['teacherId']),
                                'required' => TRUE,
                                'extraClasses' => '',
                            ])
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0">
            <div class="font-bold text-white">Where</div>
            @livewire('continent-country-region', [
                'selectedContinent' => old('continentId', $searchParameters['continentId']),
                'selectedCountry' => old('countryId', $searchParameters['countryId']),
                'selectedRegion' => old('regionId', $searchParameters['regionId']),
            ])
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0">
            <div class="font-bold text-white">When</div>

            @include('partials.forms.inputFlatPickrDatePicker', [
                            'class' => 'flatpickr date future',
                            'label' => "",
                            'placeholder' => __('homepage-search.start_on'),
                            'name' => 'startDate',
                            'value' => old('startDate', $searchParameters['startDate']),
                            'required' => true,
                            'disabled' => false,
                        ])

            <div class="mt-4">
                @include('partials.forms.inputFlatPickrDatePicker', [
                            'class' => 'flatpickr date future',
                            'label' => "",
                            'placeholder' => __('homepage-search.end_on'),
                            'name' => 'endDate',
                            'value' => old('endDate', $searchParameters['endDate']),
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