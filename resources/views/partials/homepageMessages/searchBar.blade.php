{{-- Search bar - Homepage messages --}}
<form id="searchPostsForm" method="get" action="#" class="mb-4">
    <div class="md:grid md:grid-cols-6 md:gap-2">
        {{-- Name --}}
        <div class="md:col-span-2 mb-2 md:mb-0">
            @include('partials.forms.input', [
                            'label' => __('general.title'),
                            'name' => 'title',
                            'placeholder' => '',
                            'value' => old('title', $searchParameters['title']),
                            'required' => false,
                            'disabled' => false,
                    ])
        </div>

        {{-- Search / Reset buttons --}}
        <div class="md:col-span-4 flex items-end justify-end mt-4 md:mt-0 mb-2">
            <button type="submit" name="btn_submit" class="blueButton mediumButton mr-2">
                @lang('general.search')
            </button>

            <a href="{{ route('teachers.index') }}" target="_self" class="grayButton mediumButton">
                @lang('general.reset')
            </a>
        </div>
    </div>
</form>