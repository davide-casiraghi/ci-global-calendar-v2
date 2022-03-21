@extends((( Session::get('showBackend')) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('event.create_new_event')
@endsection

{{--
  The custom js to manage the event repetition dates is stored in:
  resources/js/snippets/event_repetition.js
--}}

@section('content')

    @include('partials.messages')

    <form id="createEvent" class="space-y-6" method="POST" action="{{ route('events.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">

            <div class="md:grid md:grid-cols-3 md:gap-6">

                {{-- Notice --}}
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.notice')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.first_country_event_notice')
                    </p>
                </div>

                {{-- Notice contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">

                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('views.title'),
                                    'name' => 'title',
                                    'placeholder' => '',
                                    'value' => old('title'),
                                    'required' => TRUE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('event.category'),
                                'name' => 'event_category_id',
                                'placeholder' => __('views.select_category'),
                                'records' => $eventCategories,
                                'optionShowsField' => 'name',
                                'selected' => old('event_category_id'),
                                'required' => TRUE,
                                'extraClasses' => '',
                            ])
                        </div>
                    </div>
                </div>

                {{-- People --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.people')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.select_one_or_more_people')
                    </p>
                </div>

                {{-- People contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @livewire('modals.add-teacher', [
                            'teachers' => $teachers,
                            'selected' => null,
                            ])
                        </div>

                        <div class="col-span-6">
                            @livewire('modals.add-organizer', [
                            'organizers' => $organizers,
                            'selected' => null,
                            ])
                        </div>

                    </div>
                </div>

                {{-- Venue --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('general.venue')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.select_venue')
                    </p>
                </div>

                {{-- Venue contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.venue'),
                                'name' => 'venue_id',
                                'placeholder' => __('event.select_venue'),
                                'records' => $venues,
                                'optionShowsField' => 'name',
                                'selected' => old('venue_id'),
                                'required' => TRUE,
                                'extraClasses' => 'select2',
                            ])
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('general.description')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.please_insert_english_translation')
                    </p>
                </div>

                {{-- Description contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('general.description'),
                                   'name' => 'description',
                                   'placeholder' => '',
                                   'value' => old('description'),
                                   'required' => TRUE,
                                   'disabled' => FALSE,
                                   'style' => 'tinymce',
                                   //'extraDescription' => 'Anything to show jumbo style after the content',
                               ])
                        </div>

                    </div>
                </div>


                {{-- Duration --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.start_end_duration')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('event.please_use_repeat_until')
                    </p>
                </div>

                {{-- Duration contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">

                    {{-- Start date --}}
                    {{--<div class="grid grid-cols-6 gap-y-3 lg:gap-6">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                'class' => 'datepicker all',
                                'label' => __('event.date_start'),
                                'placeholder' => __('general.select_date'),
                                'name' => 'startDate',
                                'value' => old('startDate'),
                                'required' => true,
                                'disabled' => false,
                            ])
                        </div>
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputTimePicker', [
                                      'label' =>  __('event.time_start'),
                                      'name' => 'timeStart',
                                      'placeholder' => __('event.select_time'),
                                      'value' => [
                                            'hours' => old('timeStartHours'),
                                            'minutes' => old('timeStartMinutes'),
                                            'ampm' => old('timeStartAmpm'),
                                            ],
                                      'required' => true,
                                ])
                        </div>
                    </div>--}}

                    {{-- End date --}}
                    {{--<div class="grid grid-cols-6 gap-y-3 lg:gap-6 mt-4 lg:mt-2">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputDatePicker',[
                                    'class' => 'datepicker all',
                                    'label' => __('event.date_end'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'endDate',
                                    'value' => old('endDate'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                        </div>
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputTimePicker', [
                                     'label' =>  __('event.time_end'),
                                     'name' => 'timeEnd',
                                     'placeholder' => __('event.select_time'),
                                     'value' => [
                                            'hours' => old('timeEndHours'),
                                            'minutes' => old('timeEndMinutes'),
                                            'ampm' => old('timeEndAmpm'),
                                            ],
                                     'required' => true,
                               ])
                        </div>
                    </div>--}}

                    {{-- Start date --}}
                    <div class="grid grid-cols-6 gap-y-3 lg:gap-6">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrDatePicker', [
                                'class' => 'flatpickr date future',
                                'label' => __('event.date_start'),
                                'placeholder' => __('views.select_date'),
                                'name' => 'startDate',
                                'value' => old('startDate'),
                                'required' => true,
                                'disabled' => false,
                            ])
                        </div>
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrTimePicker', [
                               'class' => 'flatpickr justTime',
                               'label' => __('event.time_start'),
                               'placeholder' => __('views.select_time'),
                               'name' => 'startTime',
                               'value' => old('startTime'),
                               'required' => true,
                               'disabled' => false,
                           ])
                        </div>
                    </div>

                    {{-- End date --}}
                    <div class="grid grid-cols-6 gap-y-3 lg:gap-6 mt-4 lg:mt-2">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrDatePicker',[
                                    'class' => 'flatpickr date future',
                                    'label' => __('event.date_end'),
                                    'placeholder' => __('views.select_date'),
                                    'name' => 'endDate',
                                    'value' => old('endDate'),
                                    'required' => true,
                                    'disabled' => false,
                                ])
                        </div>
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrTimePicker', [
                               'class' => 'flatpickr justTime',
                               'label' => __('event.time_end'),
                               'placeholder' => __('views.select_time'),
                               'name' => 'endTime',
                               'value' => old('endTime'),
                               'required' => true,
                               'disabled' => false,
                           ])
                        </div>
                    </div>

                    {{--
                    <div class="grid grid-cols-6 gap-y-3 lg:gap-6 mt-4 lg:mt-2">
                        <div class="col-span-6 lg:col-span-3">
                            <!-- Start date and time -->
                            @include('partials.forms.inputFlatPickrDateTimePicker', [
                                'class' => 'flatpickr dateTime future',
                                'label' => __('event.date_start'),
                                'placeholder' => __('views.select_date_and_time'),
                                'name' => 'startDateAndTime',
                                'value' => old('startDateAndTime'),
                                'required' => true,
                                'disabled' => false,
                            ])
                        </div>
                        <div class="col-span-6 lg:col-span-3">
                            <!-- End date and time -->
                            @include('partials.forms.inputFlatPickrDateTimePicker', [
                                'class' => 'flatpickr dateTime future',
                                'label' => __('event.date_end'),
                                'placeholder' => __('views.select_date_and_time'),
                                'name' => 'endDateAndTime',
                                'value' => old('endDateAndTime'),
                                'required' => true,
                                'disabled' => false,
                            ])
                        </div>
                    </div>
                    --}}

                    {{-- Repeat type --}}
                    @include('partials.events.repeat-event')

                </div>

                {{-- Links & Contacts --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.contacts_and_links')</h3>
                    <p class="mt-1 text-sm text-gray-500">

                    </p>
                </div>

                {{-- Links & Contacts contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.email_for_more_info'),
                                    'name' => 'contact_email',
                                    'placeholder' => '',
                                    'value' => old('contact_email'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.facebook_event'),
                                    'name' => 'facebook_event_link',
                                    'placeholder' => '',
                                    'value' => old('facebook_event_link'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.event_url'),
                                    'name' => 'website_event_link',
                                    'placeholder' => '',
                                    'value' => old('website_event_link'),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>
                    </div>
                </div>


                {{-- Event teaser image --}}
                <div class="md:col-span-1 mt-6 md:mt-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('event.event_teaser_image')</h3>
                    <p class="mt-1 text-sm text-gray-500">

                    </p>
                </div>

                {{-- Event teaser image contents --}}
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.uploadImage', [
                                      'label' => __('event.upload_event_teaser_image'),
                                      'name' => 'introimage',
                                      'required' => FALSE,
                                      'collection' => 'introimage',
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
