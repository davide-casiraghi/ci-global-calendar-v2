{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="lg:grid lg:grid-cols-6 lg:gap-2">
        {{-- Author --}}
        <div class="lg:col-span-1 mb-2 lg:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.author'),
                            'name' => 'author',
                            'placeholder' => 'Author',
                            'value' => old('author', $searchParameters['author']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Description --}}
        <div class="lg:col-span-1 mb-2 lg:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.description'),
                            'name' => 'description',
                            'placeholder' => 'Description',
                            'value' => old('description', $searchParameters['description']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Show where --}}
        <div class="lg:col-span-1 mb-2 lg:mb-0">
            @include('partials.forms.select_status', [
                       'label' => 'Show where',
                       'name' => 'show_where',
                       'placeholder' => 'Select one',
                       'records' => $showWhereOptions,
                       'selected' =>  old('show_where', $searchParameters['show_where']),
                       'required' => false,
                   ])
        </div>

        {{-- Publish --}}
        <div class="lg:col-span-1 mb-2 lg:mb-0">
            @include('partials.forms.select_status', [
                       'label' => __('views.status'),
                       'name' => 'is_published',
                       'placeholder' => __('views.select_status'),
                       'records' => $statuses,
                       'selected' =>  old('is_published', $searchParameters['is_published']),
                       'required' => false,
                   ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="lg:col-span-2 flex items-end justify-end mt-4 lg:mt-0 mb-2">

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
                 'url' => route('quotes.index'),
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