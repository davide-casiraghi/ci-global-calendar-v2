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
        <div class="md:col-span-2 mb-2 md:mb-0">
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
        <div class="md:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.orientation'),
                        'name' => 'orientation',
                        'placeholder' => 'Filter by orientation',
                        'records' => $orientations,
                        'selected' =>  old('orientation', $searchParameters['orientation']),
                        'required' => false,
                        'extraClasses' => '',
                    ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-6 flex items-end justify-end mt-4 md:mt-0 mb-2">

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
                 'url' => route('backgroundImages.index'),
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