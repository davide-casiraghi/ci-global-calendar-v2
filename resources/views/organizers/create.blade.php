@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('organizer.create_new_organizer')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('organizers.store') }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit organizer</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the organizer data
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
                        @include('partials.forms.select_multiple', [
                            'label' => __('general.country'),
                            'name' => 'country_ids',
                            'placeholder' => '',
                            'records' => $countries,
                            'optionShowsField' => 'name',
                            'selected' => old('country_ids'),
                            'required' => false,
                            'extraClasses' => 'select2',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.email_address'),
                                'name' => 'email',
                                'placeholder' => '',
                                'value' => old('email'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.phone'),
                                'name' => 'phone',
                                'placeholder' => '',
                                'value' => old('phone'),
                                'required' => false,
                                'disabled' => false,
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
                        @include('partials.forms.textarea', [
                               'label' => __('general.description'),
                               'name' => 'description',
                               'placeholder' => '',
                               'value' => old('description'),
                               'required' => false,
                               'disabled' => false,
                               'style' => 'tinymce',
                               //'extraDescription' => 'Anything to show jumbo style after the content',
                           ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.uploadImage', [
                                  'label' => __('views.upload_profile_picture'),
                                  'name' => 'profile_picture',
                                  'required' => false,
                                  'collection' => 'profile_picture',
                                  //'entity' => $organizer,
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
