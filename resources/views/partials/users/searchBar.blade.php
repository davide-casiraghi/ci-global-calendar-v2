{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Name --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.name'),
                            'name' => 'name',
                            'placeholder' => 'Name',
                            'value' => old('name', $searchParameters['name']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Surname --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.surname'),
                            'name' => 'surname',
                            'placeholder' => 'Surname',
                            'value' => old('surname', $searchParameters['surname']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Email --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.email_address'),
                            'name' => 'email',
                            'placeholder' => 'Email',
                            'value' => old('email', $searchParameters['email']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Country --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
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

        {{-- Status --}}
        <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
            @include('partials.forms.select_status', [
                       'label' => __('views.status'),
                       'name' => 'status',
                       'placeholder' => __('views.select_status'),
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
                 'url' => route('users.index'),
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