@extends('layouts.backend')

@section('title')
    @lang('organizer.edit_organizer')
@endsection

@section('buttons')
    @livewire('delete-model', [
    'model' => $organizer,
    'modelName' => 'organizer',
    'redirectRoute' => 'organizers.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('organizers.update',$organizer->id) }}" enctype="multipart/form-data">
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
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.name'),
                                'name' => 'name',
                                'placeholder' => '',
                                'value' => old('name', $organizer->name),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.surname'),
                                'name' => 'surname',
                                'placeholder' => '',
                                'value' => old('surname', $organizer->surname),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.email_address'),
                                'name' => 'email',
                                'placeholder' => '',
                                'value' => old('email', $organizer->email),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.phone'),
                                'name' => 'phone',
                                'placeholder' => '',
                                'value' => old('phone', $organizer->phone),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.website'),
                                'name' => 'website',
                                'placeholder' => '',
                                'value' => old('website', $organizer->website),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                               'label' => __('general.description'),
                               'name' => 'description',
                               'placeholder' => '',
                               'value' => old('description', $organizer->description),
                               'required' => false,
                               'disabled' => false,
                               'style' => 'tinymce',
                               'extraDescription' => 'Anything to show jumbo style after the content',
                           ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.uploadImage', [
                                  'label' => __('views.upload_profile_picture'),
                                  'name' => 'profile_picture',
                                  'required' => false,
                                  'collection' => 'profile_picture',
                                  'entity' => $organizer,
                              ])
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-3">
                @include('partials.forms.button',[
                    'title' => 'View',
                    'url' => route('organizers.show',$organizer->slug),
                    'color' => 'indigo',
                    'icon' => '<svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                    'size' => 1,
                    'extraClasses' => 'mt-4',
                    'kind' => 'secondary',
                    'target' => '_blank',
                ])
            </div>

            <div class="col-span-3">
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
