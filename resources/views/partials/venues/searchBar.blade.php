{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Name --}}
        <div class="md:col-span-3 lg:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.name'),
                            'name' => 'name',
                            'placeholder' => 'Venue name',
                            'value' => old('name', $searchParameters['name']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- City --}}
        <div class="md:col-span-3 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.city'),
                            'name' => 'city',
                            'placeholder' => 'City',
                            'value' => old('city', $searchParameters['city']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Country --}}
        <div class="md:col-span-3 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.country'),
                        'name' => 'countryId',
                        'placeholder' => __('views.select_country'),
                        'records' => $countries,
                        'selected' =>  old('countryId', $searchParameters['countryId']),
                        'required' => false,
                        'extraClasses' => 'select2',
                    ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-3 lg:col-span-2 flex items-end justify-end mt-4 md:mt-0 mb-2">
            <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
                @lang('general.search')
            </button>

            <a href="{{ route('venues.index') }}" target="_self" class="grayButton mediumButton">
                @lang('general.reset')
            </a>
        </div>
    </div>
</form>