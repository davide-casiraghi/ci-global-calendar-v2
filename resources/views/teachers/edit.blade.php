@extends((( Session::get('showBackend')) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('teacher.edit_teacher')
@endsection

@section('buttons')
    @livewire('delete-model', [
        'model' => $teacher,
        'modelName' => 'teacher',
        'redirectRoute' => 'teachers.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('teachers.update',$teacher) }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit teacher</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the teacher data
                </p>
              --}}

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.name'),
                                'name' => 'name',
                                'placeholder' => '',
                                'value' => old('name', $teacher->name),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.surname'),
                                'name' => 'surname',
                                'placeholder' => '',
                                'value' => old('surname', $teacher->surname),
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
                            'selected' => $teacher->country_id,
                            'required' => true,
                            'extraClasses' => 'select2',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                               'label' => __('teacher.bio'),
                               'name' => 'bio',
                               'placeholder' => '',
                               'value' => old('bio', $teacher->bio),
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
                                'value' => old('year_starting_practice', $teacher->year_starting_practice),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('teacher.year_of_starting_to_teach'),
                                'name' => 'year_starting_teach',
                                'placeholder' => '',
                                'value' => old('year_starting_teach', $teacher->year_starting_teach),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('teacher.significant_teachers'),
                                'name' => 'significant_teachers',
                                'placeholder' => '',
                                'value' => old('significant_teachers', $teacher->significant_teachers),
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
                                'value' => old('website', $teacher->website),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('teacher.facebook_profile'),
                                'name' => 'facebook',
                                'placeholder' => '',
                                'value' => old('facebook', $teacher->facebook),
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
                                  'entity' => $teacher,
                              ])
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="flex items-stretch justify-between">
            <a href="{{ route('teachers.show',$teacher->slug) }}" class="blueButtonInverse mediumButton">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                @lang('general.view')
            </a>

            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                    @lang('general.back')
                </a>
                <button type="submit" class="blueButton mediumButton">
                    @lang('general.submit')
                </button>
            </div>
        </div>

    </form>

@endsection
