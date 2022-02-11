@extends('layouts.backend')

@section('title')
    @lang('views.create_new_background_image')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('backgroundImages.store') }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Background image details</h3>
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
                                'label' => __('views.title'),
                                'name' => 'title',
                                'placeholder' => __('views.background_image_title'),
                                'value' => old('title'),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('homepage-search.photo_credits'),
                                'name' => 'photographer',
                                'placeholder' => __('views.who_took_the_photo'),
                                'value' => old('photographer'),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                               'label' => __('general.description'),
                               'name' => 'description',
                               'placeholder' => '',
                               'value' =>  old('description'),
                               'required' => false,
                               'disabled' => false,
                       ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.select', [
                            'label' => __('views.orientation'),
                            'name' => 'orientation',
                            'placeholder' => __('views.orientation'),
                            'records' => $orientations,
                            'required' => true,
                            'extraClasses' => '',
                        ])
                    </div>

                    {{-- Background image --}}
                    <div class="col-span-6">
                        @include('partials.forms.uploadImage', [
                                  'label' => __('event.upload_event_teaser_image'),
                                  'name' => 'background_image',
                                  'required' => FALSE,
                                  'collection' => 'background_image',
                                  //'entity' => $event,
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
