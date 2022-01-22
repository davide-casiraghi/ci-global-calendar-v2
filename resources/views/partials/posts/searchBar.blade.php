{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
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
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.category'),
                        'name' => 'categoryId',
                        'placeholder' => __('views.select_category'),
                        'records' => $categories,
                        'selected' =>  old('categoryId', $searchParameters['categoryId']),
                        'required' => false,
                        'extraClasses' => '',
                    ])
        </div>

        {{-- Creation date before --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date past',
                'label' => 'Created before',
                'placeholder' => __('views.select_date'),
                'name' => 'startDate',
                'value' =>  old('startDate', $searchParameters['startDate']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Creation date after --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date past',
                'label' => 'Created after',
                'placeholder' => __('views.select_date'),
                'name' => 'endDate',
                'value' =>  old('endDate', $searchParameters['endDate']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Status --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.select_status', [
                       'label' => __('views.status'),
                       'name' => 'status',
                       'placeholder' => __('views.select_one'),
                       'records' => $statuses,
                       'selected' =>  old('status', $searchParameters['status']),
                       'required' => false,
                   ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-2 lg:col-span-1 flex items-end justify-end mt-4 md:mt-0 mb-2">

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
                 'url' => route('posts.index'),
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