{{-- Search bar - Posts --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-12 md:gap-2">
        {{-- Title --}}
        <div class="md:col-span-3 lg:col-span-2 mb-2 md:mb-0">
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
        <div class="md:col-span-3 lg:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.select', [
                        'label' => __('views.category'),
                        'name' => 'category_id',
                        'placeholder' => __('views.select_category'),
                        'records' => $categories,
                        'selected' =>  old('category_id', $searchParameters['category_id']),
                        'required' => false,
                        'extraClasses' => '',
                    ])
        </div>

        {{-- Creation date before --}}
        <div class="md:col-span-3 lg:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date past',
                'label' => 'Created before',
                'placeholder' => __('views.select_date'),
                'name' => 'start_date',
                'value' =>  old('start_date', $searchParameters['start_date']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Creation date after --}}
        <div class="md:col-span-3 lg:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.inputFlatPickrDatePicker',[
                'class' => 'flatpickr date past',
                'label' => 'Created after',
                'placeholder' => __('views.select_date'),
                'name' => 'end_date',
                'value' =>  old('end_date', $searchParameters['end_date']),
                'required' => false,
                'disabled' => false,
            ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-12 lg:col-span-4 flex items-end justify-end mt-4 md:mt-0 mb-2">
            <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
                @lang('general.search')
            </button>

            <a href="{{ route('posts.index') }}" target="_self" class="grayButton mediumButton">
                @lang('general.reset')
            </a>
        </div>
    </div>
</form>