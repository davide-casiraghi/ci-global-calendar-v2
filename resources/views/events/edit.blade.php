@extends('layouts.backend')

@section('title')
    @lang('event.edit_event')
@endsection

@section('buttons')
    @livewire('delete-model', [
    'model' => $event,
    'modelName' => 'event',
    'redirectRoute' => 'events.index'
    ])
@endsection

{{--
  The custom js to manage the event repetition dates is stored in:
  resources/js/snippets/event_repetition.js
--}}

@section('content')

    @include('partials.messages')

    <form id="editEvent" class="space-y-6" method="POST" action="{{ route('events.update',$event->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                    'value' => old('title', $event->title),
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
                                'selected' => $event->event_category_id,
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
                            @livewire('add-teacher', [
                                'teachers' => $teachers,
                                'selected' => $event->teachers->modelKeys(),
                            ])

                            {{--@include('partials.forms.select_multiple', [
                                'label' => __('general.teachers'),
                                'name' => 'teacher_ids',
                                'placeholder' => __('event.select_teachers'),
                                'records' => $teachers,
                                'value_attribute_name' => 'full_name',
                                'selected' => $event->teachers->modelKeys(),
                                'required' => false,
                                'extraClasses' => '',
                            ])--}}
                        </div>

                        <div class="col-span-6">
                            @livewire('add-organizer', [
                            'organizers' => $organizers,
                            'selected' => $event->organizers->modelKeys(),
                            ])

                            {{--@include('partials.forms.select_multiple', [
                                'label' => __('general.organizers'),
                                'name' => 'organizer_ids',
                                'placeholder' => __('event.select_organizers'),
                                'records' => $organizers,
                                'value_attribute_name' => 'full_name',
                                'selected' => $event->organizers->modelKeys(),
                                'required' => false,
                                'extraClasses' => '',
                            ])--}}
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
                                'selected' => $event->venue_id,
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
                                   'value' => old('description', $event->description),
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
                    <div class="grid grid-cols-6 gap-y-3 lg:gap-6">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrDatePicker', [
                                'class' => 'flatpickr date all',
                                'label' => __('event.date_start'),
                                'placeholder' => __('views.select_date'),
                                'name' => 'startDate',
                                'value' => old('startDate', $eventDateTimeParameters['startDate']),
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
                               'value' => old('startTime', $eventDateTimeParameters['startTime']),
                               'required' => true,
                               'disabled' => false,
                           ])
                        </div>
                    </div>

                    {{-- End date --}}
                    <div class="grid grid-cols-6 gap-y-3 lg:gap-6 mt-4 lg:mt-2">
                        <div class="col-span-6 lg:col-span-3">
                            @include('partials.forms.inputFlatPickrDatePicker',[
                                    'class' => 'flatpickr date all',
                                    'label' => __('event.date_end'),
                                    'placeholder' => __('views.select_date'),
                                    'name' => 'endDate',
                                    'value' => old('endDate', $eventDateTimeParameters['endDate']),
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
                               'value' => old('endTime', $eventDateTimeParameters['endTime']),
                               'required' => true,
                               'disabled' => false,
                           ])
                        </div>
                    </div>

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
                                    'value' => old('contact_email', $event->contact_email),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.facebook_event'),
                                    'name' => 'facebook_event_link',
                                    'placeholder' => '',
                                    'value' => old('facebook_event_link', $event->facebook_event_link),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('event.event_url'),
                                    'name' => 'website_event_link',
                                    'placeholder' => '',
                                    'value' => old('website_event_link', $event->website_event_link),
                                    'required' => FALSE,
                                    'disabled' => FALSE,
                            ])
                        </div>

                        {{-- Published --}}
                        <div class="col-span-6">
                            @php
                                $checked = ($event->isPublished()) ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.published'),
                                'id'  => 'is_published',
                                'name' => 'is_published',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
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
                                      'entity' => $event,
                                  ])
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex items-stretch justify-between">
            <a href="{{ route('events.show',$event->slug) }}" class="blueButtonInverse mediumButton">
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
