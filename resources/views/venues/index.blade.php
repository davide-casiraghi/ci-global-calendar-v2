@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('eventVenue.events_venue_management')
@endsection

@section('buttons')
    <a href="{{ route('venues.create') }}" target="_self" class="blueButton smallButton">
        @lang('views.add_new_venue')
    </a>
@endsection

@section('content')

    @include('partials.venues.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($venues as $venue)
                @include('partials.venues.indexItem', [
                    'venue' => $venue
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $venues->appends([
                'name' => $searchParameters['name'] ?? '',
                'city' => $searchParameters['city'] ?? '',
                'countryId' => $searchParameters['countryId'] ?? '',
            ])->links()
        }}
    </div>

@endsection
