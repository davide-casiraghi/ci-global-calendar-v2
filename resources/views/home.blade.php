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

    <div class="relative flex-grow-0 flex-shrink-0 px-4 w-full max-w-full tracking-tight leading-6 text-center text-gray-900 box-border"
            style="flex-basis: 100%;">
        <h1 class="mx-0 mt-20 mb-4 text-4xl font-medium text-center text-white box-border" style="line-height: 1.2;">
            Contact Improvisation
        </h1>
        <h4 class="mt-0 mb-2 font-sans text-2xl font-semibold tracking-normal text-gray-500 uppercase box-border" style="line-height: 1.125;">
            <strong class="leading-7 uppercase box-border" style="font-weight: bolder;">
                - Global Calendar -
            </strong>
        </h4>
        <p class="mt-0 mb-4 leading-6 text-white box-border">
            Find information about Contact Improvisation events worldwide (classes,
            jams, workshops, festivals and more)<br class="text-center box-border" />
        </p>
        <p class="mt-0 mb-4 leading-6 text-gray-900 box-border"></p>
        <p class="mt-12 mb-4 leading-6 text-white box-border">
            Use one or more search criteria
        </p>
    </div>

    @include('partials.home.searchForm')
    @include('partials.home.searchResults')

@endsection

