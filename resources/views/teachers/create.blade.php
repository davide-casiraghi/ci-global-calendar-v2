@extends((( Session::get('showBackend')) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('teacher.create_new_teacher')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Create teacher</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the teacher data
                </p>
              --}}

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.name'),
                                'name' => 'name',
                                'placeholder' => '',
                                'value' => old('name'),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.surname'),
                                'name' => 'surname',
                                'placeholder' => '',
                                'value' => old('surname'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.select', [
                            'label' => __('general.country'),
                            'name' => 'country_id',
                            'placeholder' => '',
                            'records' => $countries,
                            'optionShowsField' => 'name',
                            'selected' =>  old('country_id'),
                            'required' => true,
                            'extraClasses' => 'select2',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                               'label' => __('teacher.bio'),
                               'name' => 'bio',
                               'placeholder' => '',
                               'value' => old('bio'),
                               'required' => false,
                               'disabled' => false,
                               'style' => 'tinymce',
                               //'extraDescription' => 'Anything to show jumbo style after the content',
                           ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('teacher.year_of_starting_to_practice'),
                                'name' => 'year_starting_practice',
                                'placeholder' => '',
                                'value' => old('year_starting_practice'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('teacher.year_of_starting_to_teach'),
                                'name' => 'year_starting_teach',
                                'placeholder' => '',
                                'value' => old('year_starting_teach'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('teacher.significant_teachers'),
                                'name' => 'significant_teachers',
                                'placeholder' => '',
                                'value' => old('significant_teachers'),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
                                //'extraDescription' => 'Anything to show jumbo style after the content',
                            ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.website'),
                                'name' => 'website',
                                'placeholder' => '',
                                'value' => old('website'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('teacher.facebook_profile'),
                                'name' => 'facebook',
                                'placeholder' => '',
                                'value' => old('facebook'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.uploadImage', [
                                  'label' => __('teacher.upload_profile_picture'),
                                  'name' => 'profile_picture',
                                  'required' => false,
                                  'collection' => 'profile_picture',
                                  //'entity' => $teacher,
                              ])
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                @lang('general.back')
            </a>
            <button type="submit" class="blueButton mediumButton">
                @lang('general.submit')
            </button>
        </div>
    </form>

@endsection
