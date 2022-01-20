@extends('layouts.backend')

@section('title')
    @lang('event.events_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add event',
        'url' => route('events.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    @include('partials.forms.button',[
         'title' => 'Event Categories',
         'url' => route('eventCategories.index'),
         'color' => 'yellow',
         'icon' => '',
         'size' => 1,
         'extraClasses' => 'mb-4',
         'kind' => 'white',
         'target' => '_self',
     ])

    @include('partials.forms.button',[
     'title' => 'Teachers',
     'url' => route('teachers.index'),
     'color' => 'yellow',
     'icon' => '',
     'size' => 1,
     'extraClasses' => 'mb-4',
     'kind' => 'white',
     'target' => '_self',
    ])

    @include('partials.forms.button',[
     'title' => 'Organizers',
     'url' => route('organizers.index'),
     'color' => 'yellow',
     'icon' => '',
     'size' => 1,
     'extraClasses' => 'mb-4',
     'kind' => 'white',
     'target' => '_self',
    ])

    @include('partials.forms.button',[
     'title' => 'Venues',
     'url' => route('venues.index'),
     'color' => 'yellow',
     'icon' => '',
     'size' => 1,
     'extraClasses' => 'mb-4',
     'kind' => 'white',
     'target' => '_self',
    ])
@endsection

@section('content')

    @include('partials.events.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($events as $event)
                @include('partials.events.indexItem', [
                    'event' => $event
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $events->links() }}
    </div>


@endsection
