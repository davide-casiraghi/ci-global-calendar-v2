@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('eventVenue.edit_venue')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('venues.update',$venue) }}" enctype="multipart/form-data">
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
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.name'),
                                'name' => 'name',
                                'placeholder' => '',
                                'value' => old('name', $venue->name),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('eventVenue.street'),
                                'name' => 'address',
                                'placeholder' => '',
                                'value' => old('address', $venue->address),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('eventVenue.city'),
                                'name' => 'city',
                                'placeholder' => '',
                                'value' => old('city', $venue->city),
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
                            'selected' => $venue->country_id,
                            'required' => true,
                            'extraClasses' => 'select2',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('eventVenue.zip_code'),
                                'name' => 'zip_code',
                                'placeholder' => '',
                                'value' => old('zip_code', $venue->zip_code),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('eventVenue.extra_info'),
                                'name' => 'extra_info',
                                'placeholder' => '',
                                'value' => old('zip_code', $venue->extra_info),
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
                                'value' => old('website', $venue->website),
                                'required' => false,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                               'label' => __('general.description'),
                               'name' => 'description',
                               'placeholder' => '',
                               'value' => old('description', $venue->description),
                               'required' => false,
                               'disabled' => false,
                               'style' => 'tinymce',
                               //'extraDescription' => 'Anything to show jumbo style after the content',
                           ])
                    </div>

                    <div class="col-span-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-1">Happening in this venue</h3>

                        @forelse($venue->events as $event)
                            <a class='mb-2 text-base text-primary-600 hover:text-primary-700' href="{{route('events.edit', $event)}}" target="_blank">{{$event->title}}</a> <br>
                        @empty
                            No events in this venue
                        @endforelse
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="flex items-stretch justify-between">
            <a href="{{ route('venues.show',$venue) }}" class="blueButtonInverse mediumButton">
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
