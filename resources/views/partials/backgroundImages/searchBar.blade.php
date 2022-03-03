{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-12 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.title'),
                            'name' => 'title',
                            'placeholder' => 'Image title',
                            'value' => old('title', $searchParameters['title']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Credits - Photographer name --}}
        <div class="md:col-span-3 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.photographer'),
                            'name' => 'photographer',
                            'placeholder' => 'Search by photographer name',
                            'value' => old('credits', $searchParameters['photographer']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Orientation --}}
        <div class="md:col-span-3 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.orientation'),
                        'name' => 'orientation',
                        'placeholder' => 'Filter by orientation',
                        'records' => $orientations,
                        'optionShowsField' => 'name',
                        'selected' =>  old('orientation', $searchParameters['orientation']),
                        'required' => false,
                        'extraClasses' => '',
                    ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-4 flex items-end justify-end mt-4 md:mt-0 mb-2">
            <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
                @lang('general.search')
            </button>

            <a href="{{ route('backgroundImages.index') }}" target="_self" class="grayButton mediumButton">
                @lang('general.reset')
            </a>
        </div>
    </div>
</form>