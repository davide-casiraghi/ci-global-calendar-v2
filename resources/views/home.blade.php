@extends('layouts.app')

@section('fb-tags')
    <x-social-meta
            :title="__('general.website_name')"
            :description="__('general.website_description')"
            :image="asset('images/static_pages/hp-intro-image.jpg')"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('content')

    <div class="eventSearch relative inline-block px-4 w-full max-w-full tracking-tight leading-6 text-gray-900"> {{-- Removed flex-grow maybe subtitute with grow --}}

        <div class="max-w-5xl m-auto mt-2">
            @include('partials.messages')
            @livewire('show-homepage-message') {{-- The HP messages are created from the backend by the administrators --}}
        </div>

        <div class="frontFrame relative z-20">
            <div class="text-center">
                <div class="text-white mx-0 mt-20 mb-4 text-5xl font-medium text-white mb-4">
                    @lang('homepage-search.contact_improvisation')
                </div>
                <h4 class="mt-0 mb-2 font-sans text-2xl font-semibold tracking-normal text-gray-300 uppercase">
                    - @lang('homepage-search.global_calendar') -
                </h4>
                <div class="mt-0 mb-4 leading-6 text-white">
                    @lang('homepage-search.find_information')
                </div>
                <div class="mt-12 mb-4 leading-6 text-white">
                    @lang('homepage-search.criteria')
                </div>
            </div>

            <div class="max-w-5xl m-auto">
                @include('partials.home.searchForm')
                @include('partials.home.searchResults')
            </div>

            <div class="backgroundCredits my-3 text-gray-300 text-xs">
                @lang('homepage-search.photo_credits')
                <div class="credits inline"></div>
            </div>
        </div>
        @include('partials.home.backgroundChanger')
    </div>
@endsection
