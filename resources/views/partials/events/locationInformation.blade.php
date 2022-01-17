<div class="mb-6">
    <div class="whiteBox">
        <h2 class="leading-6 text-2xl font-semibold text-gray-700 mb-4">{{ $event->venue->name }}</h2>
        <div class="text-gray-600">
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

        <div class="easyRead font-avenir text-gray-900 text-lg leading-8 mt-8">
            {!! $event->venue->description !!}
        </div>
    </div>

    <div class="mt-6" id="map">
        @include('partials.events.gmap', [
              'venue_name' => $event->venue->name,
              'venue_address' => $event->venue->address,
              'venue_city' => $event->venue->city,
              'venue_country' => $event->venue->country->name,
              'venue_zip_code' => $event->venue->zip_code
        ])
    </div>
</div>