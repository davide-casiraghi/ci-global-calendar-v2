{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-4 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('views.tag'),
                            'name' => 'tag',
                            'placeholder' => 'Tag',
                            'value' => old('tag', $searchParameters['tag']),
                            'required' => false,
                            'disabled' => false,
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
                 'url' => route('tags.index'),
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