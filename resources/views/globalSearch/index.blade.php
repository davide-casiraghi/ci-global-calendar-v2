@extends('layouts.backend')

@section('title')
    Global search
@endsection

@section('content')

    <div class="font-bold text-lg">{{ $searchResults->count() }} results found for "{{ request('keyword') }}"</div>

    <div class="my-4">

        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
            <div class="mb-4">
                <h2>{{ ucfirst($type) }}</h2>

                @foreach($modelSearchResults as $searchResult)
                    <ul>
                        <li><a class="text-blue-600" href="{{ $searchResult->url }}">{{ $searchResult->title }}</a></li>
                    </ul>
                @endforeach
            </div>
        @endforeach

    </div>

@endsection
