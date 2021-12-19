@extends('layouts.backend')

@section('title')
    @lang('views.edit_background_image')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('backgroundImages.update', $backgroundImage->id) }}" enctype="multipart/form-data">
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
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('views.title'),
                                'name' => 'title',
                                'placeholder' => __('views.background_image_title'),
                                'value' => old('title', $backgroundImage->title),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('homepage-search.photo_credits'),
                                'name' => 'photographer',
                                'placeholder' => __('views.who_took_the_photo'),
                                'value' => old('photographer', $backgroundImage->photographer),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                               'label' => __('general.description'),
                               'name' => 'description',
                               'placeholder' => '',
                               'value' =>  old('description', $backgroundImage->description),
                               'required' => false,
                               'disabled' => false,
                               'style' => 'tinymce',
                               //'extraDescription' => 'Anything to show jumbo style after the content',
                           ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.select', [
                            'label' => __('views.orientation'),
                            'name' => 'orientation',
                            'placeholder' => __('views.orientation'),
                            'records' => $orientations,
                            'selected' => $backgroundImage->orientation,
                            'required' => true,
                            'extraClasses' => '',
                        ])
                    </div>

                    {{-- Background image  --}}
                    <div class="col-span-6">
                        @include('partials.forms.uploadImage', [
                                  'label' => __('event.upload_event_teaser_image'),
                                  'name' => 'background_image',
                                  'required' => FALSE,
                                  'collection' => 'background_image',
                                  'entity' => $backgroundImage,
                              ])
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6">
                <div class="flex justify-end mt-4">
                    <a href="{{ url()->previous() }}">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection
