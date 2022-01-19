@extends('layouts.app')

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mt-10 mb-10 px-10 text-gray-500">

        <h2 class="mt-20 mb-8 text-3xl leading-8 font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
            Teachers directory
        </h2>

        @livewire('teachers-directory')

    </div>

@endsection