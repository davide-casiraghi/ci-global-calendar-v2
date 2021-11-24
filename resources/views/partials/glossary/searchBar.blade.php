{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.title'),
                            'name' => 'term',
                            'placeholder' => 'Glossary term',
                            'value' => old('term', $searchParameters['term']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Publish --}}
        <div class="md:col-span-2 mb-2 md:mb-0">
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
        <div class="md:col-span-2 flex items-end justify-end mt-4 md:mt-0 mb-2">

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
                 'url' => route('glossaries.index'),
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
