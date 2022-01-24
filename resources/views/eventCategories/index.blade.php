@extends('layouts.backend')

@section('title')
    Event category management
@endsection

@section('buttons')
    <a href="{{ route('eventCategories.create') }}" target="_self" class="blueButton smallButton">
        @lang('eventCategory.add_new_event_category')
    </a>
@endsection

@section('content')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($eventCategories as $eventCategory)
                @include('partials.eventCategory.indexItem', [
                    'eventCategory' => $eventCategory
                ])
            @endforeach
        </ul>
    </div>

   {{--<div class="my-5">
        {{ $eventsCategories->links() }}
    </div>--}}


@endsection
