@extends('layouts.app')

{{--
    Glossary tooltips loaded in:
    resources/js/vendors/staaky_tipped.js
--}}

@section('fb-tags')
    <x-social-meta
        :title="$event->title . ' - ' . $event->venue->name . ' - ' . $event->venue->city . ', ' . $event->venue->country->name"
        :image="$event->hasMedia('introimage') ?
                $event->getMedia('introimage')[0]->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('structured-data')
    {!! $event->toJsonLdScript() !!}
@endsection


@section('content')

    <div class="eventShow max-w-prose mx-auto mt-8">
        @include('partials.messages')

        <div class="md:flex md:justify-between bg-white rounded-t pt-8 px-6">
            <h1 class="leading-6 text-2xl font-semibold text-gray-700">
                {{ $event->title }}
            </h1>

            @livewire('write-for-more-info', [
                'event' => $event,
            ])
        </div>

        @include('partials.events.mainInformation')
        @include('partials.events.socialInformation')

        <div class="easyRead whiteBox font-avenir text-gray-900 text-lg leading-8 my-6"> {{-- prose text-gray-500 text-lg mb-10 --}}

            @if($event->hasMedia('introimage'))
                <img class="float-right w-72 ml-4 mb-4" src="{{$event->getMedia('introimage')[0]->getUrl()}}" alt="event image">
            @endif
            {!! $event->description !!}
        </div>

        <div class="flex justify-between mb-4">
            @livewire('claim-event', [
                'event' => $event,
            ])

            @livewire('report-misuse', [
                'event' => $event,
            ])
        </div>


        @include('partials.events.locationInformation')
    </div>

@endsection
