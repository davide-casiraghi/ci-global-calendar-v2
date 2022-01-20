@extends('layouts.backend')

@section('title')
    @lang('eventVenue.events_venue_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add venue',
        'url' => route('venues.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
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
        {{ $venues->links() }}
    </div>


@endsection
