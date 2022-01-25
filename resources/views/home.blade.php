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

    <div class="eventSearch relative inline-block flex-grow-0 flex-shrink-0 px-4 w-full max-w-full tracking-tight leading-6 text-gray-900 box-border"
            style="flex-basis: 100%;">

        @include('partials.messages')
        <div class="frontFrame relative z-20">
            <div class="text-center">
                <div class="text-white mx-0 mt-20 mb-4 text-5xl font-medium text-white box-border mb-4">
                    Contact Improvisation
                </div>
                <h4 class="mt-0 mb-2 font-sans text-2xl font-semibold tracking-normal text-gray-500 uppercase box-border leading-7">
                    - Global Calendar -
                </h4>
                <p class="mt-0 mb-4 leading-6 text-white box-border">
                    @lang('homepage-search.find_information')
                </p>
                <p class="mt-0 mb-4 leading-6 text-gray-900 box-border"></p>
                <p class="mt-12 mb-4 leading-6 text-white box-border">
                    @lang('homepage-search.criteria')
                </p>
            </div>

            <div class="max-w-5xl m-auto">
                @include('partials.home.searchForm')
                @include('partials.home.searchResults')
            </div>

            <div class="backgroundCredits my-3 text-gray-300 text-xs">
                Photo credits:
                <div class="credits inline"></div>
            </div>
        </div>
        @include('partials.home.backgroundChanger')
    </div>
@endsection

