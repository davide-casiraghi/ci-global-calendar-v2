@extends('layouts.backend')

@section('title')
    Homepage message management
@endsection

@section('buttons')
    <a href="{{ route('homepageMessages.create') }}" target="_self" class="blueButton smallButton">
        Create new homepage message
    </a>
@endsection

@section('content')

    @include('partials.homepageMessages.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($homepageMessages as $homepageMessage)
                @include('partials.homepageMessages.indexItem', [
                    'homepageMessage' => $homepageMessage
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $homepageMessages->links() }}
    </div>

@endsection
