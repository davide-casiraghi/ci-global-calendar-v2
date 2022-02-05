{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-12 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.title'),
                            'name' => 'title',
                            'placeholder' => 'Post title',
                            'value' => old('title', $searchParameters['title']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Category --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.category'),
                        'name' => 'event_category_id',
                        'placeholder' => __('views.select_category'),
                        'records' => $eventsCategories,
                        'selected' =>  old('event_category_id', $searchParameters['event_category_id']),
                        'required' => false,
                        'extraClasses' => '',
                    ])
        </div>

        {{-- Status --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.select_status', [
                       'label' => __('views.status'),
                       'name' => 'is_published',
                       'placeholder' => __('views.select_one'),
                       'records' => $statuses,
                       'selected' =>  old('is_published', $searchParameters['is_published']),
                       'required' => false,
                   ])
        </div>

        {{-- Creation date before --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date all',
                'label' => __('event.date_start'),
                'placeholder' => __('homepage-search.start_on'),
                'name' => 'start_repeat',
                'value' =>  old('start_repeat', $searchParameters['start_repeat']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Creation date after --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date all',
                'label' => __('event.date_end'),
                'placeholder' => __('homepage-search.end_on'),
                'name' => 'end_repeat',
                'value' =>  old('end_repeat', $searchParameters['end_repeat']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-4 xl:col-span-2 flex items-end justify-end mt-4 md:mt-0 mb-2">
            <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
                @lang('general.search')
            </button>

            <a href="{{ route('events.index') }}" target="_self" class="grayButton mediumButton">
                @lang('general.reset')
            </a>
        </div>
    </div>
</form>
