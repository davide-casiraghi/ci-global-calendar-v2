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
                        'name' => 'eventCategoryId',
                        'placeholder' => __('views.select_category'),
                        'records' => $eventsCategories,
                        'selected' =>  old('eventCategoryId', $searchParameters['eventCategoryId']),
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
            @include('partials.forms.inputDatePicker',[
                'class' => 'datepicker all',
                'label' => __('event.date_start'),
                'placeholder' => __('views.select_date'),
                'name' => 'startDate',
                'value' =>  old('startDate', $searchParameters['startDate']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Creation date after --}}
        <div class="md:col-span-4 xl:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.inputDatePicker',[
                'class' => 'datepicker all',
                'label' => __('event.date_end'),
                'placeholder' => __('views.select_date'),
                'name' => 'endDate',
                'value' =>  old('endDate', $searchParameters['endDate']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-4 xl:col-span-2 flex items-end justify-end mt-4 md:mt-0 mb-2">

            @include('partials.forms.button_submit',[
                     'title' => __('general.search'),
                     'color' => 'indigo',
                     'icon' => '',
                     'size' => 2,
                     'extraClasses' => 'mr-2',
                     'kind' => 'primary',
                 ])

            @include('partials.forms.button',[
                 'title' => 'Reset',
                 'url' => route('events.index'),
                 'color' => 'yellow',
                 'icon' => '',
                 'size' => 2,
                 'extraClasses' => '',
                 'kind' => 'white',
                 'target' => '_self',
             ])
        </div>
    </div>
</form>
