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

@section('jumbotron')
    @if($event->hasMedia('introimage'))
        <div class="{{--bg-fixed--}} relative bg-cover bg-no-repeat" style="background-image: url('{{$event->getMedia('introimage')[0]->getUrl()}}'); ">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10 text-white">
                <h2 class="text-4xl font-bold mb-2">
                    {{ $event->title }}
                </h2>

                @include('partials.events.mainInformation')

            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute"></div>
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10 text-gray-500">
        @if(!$event->hasMedia('introimage'))
            <h1>
                {{ $event->title }}
            </h1>

            @include('partials.events.mainInformation')
        @endif

        <div class="easyRead font-avenir text-gray-900 text-xl mb-10 leading-9"> {{-- prose text-gray-500 text-lg mb-10 --}}
            {!! $event->description !!}
        </div>

        {{-- Location --}}
        <div class="">
            <div class="">
                <h2>{{ $event->venue->name }}</h2>
                <div class="">
                    {{ $event->venue->address }}<br />
                    {{ $event->venue->city }}<br />
                    {{--@if(!empty($region->name)){{ $region->name }}<br /> @endif--}}
                    {{ $event->venue->zip_code }}<br />
                    <b>{{ $event->venue->country->name }}</b><br />
                </div>

                @if(!empty($event->venue->website))
                    <div class="flex mt-4">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <a class="textLink" href="{{ $event->venue->website }}" target="_blank">{{ $event->venue->website }}</a>
                    </div>
                @endif

                @if(!empty($event->venue->extra_info))
                    <div class="mt-4">
                        {!! $event->venue->extra_info !!}
                    </div>
                @endif

                <div class="easyRead font-avenir text-gray-900 text-xl leading-9 mt-4">
                {!! $event->venue->description !!}
                </div>
            </div>

            <div class="mt-4" id="map">
                @include('partials.events.gmap', [
                      'venue_name' => $event->venue->name,
                      'venue_address' => $event->venue->address,
                      'venue_city' => $event->venue->city,
                      'venue_country' => $event->venue->country->name,
                      'venue_zip_code' => $event->venue->zip_code
                ])
            </div>
        </div>


    </div>
@endsection
