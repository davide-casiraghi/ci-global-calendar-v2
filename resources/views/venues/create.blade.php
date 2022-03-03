@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('eventVenue.add_new_venue')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('venues.store') }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit venue</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the venue data
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
                                'label' => __('eventVenue.street'),
                                'name' => 'address',
                                'placeholder' => '',
                                'value' => old('address'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('eventVenue.city'),
                                'name' => 'city',
                                'placeholder' => '',
                                'value' => old('city'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    @livewire('country-region-select', [
                    'selectedCountry' => old('country_id'),
                    'selectedRegion' => old('region_id'),
                    ])

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('eventVenue.zip_code'),
                                'name' => 'zip_code',
                                'placeholder' => '',
                                'value' => old('zip_code'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('eventVenue.extra_info'),
                                'name' => 'extra_info',
                                'placeholder' => '',
                                'value' => old('zip_code'),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
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
