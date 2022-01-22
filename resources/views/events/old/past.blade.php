@extends('layouts.app')

@section('title')@lang('event.past_events_title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 mb-10 md:mt-6">

        <div class="border-gray-400 border-solid border-0 box-border leading-6 pt-6 pb-8 text-black">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Past events
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                The past events in our agenda
            </p>
        </div>

        <div class="mb-10">
            @forelse($events as $event)
                @include('partials.events.eventItem')
            @empty
                No events found
            @endforelse
        </div>
        @if( $events instanceof \Illuminate\Pagination\LengthAwarePaginator )
            <div class="my-5">
                {{ $events->links() }}
            </div>
        @endif
        <div class="text-center mt-6">
            <a href="{{ route('events.next') }}" class="font-medium rounded-md text-white px-4 py-2 bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary active:bg-primary-700 transition ease-in-out duration-150">Next events</a>
        </div>
    </div>

@endsection
