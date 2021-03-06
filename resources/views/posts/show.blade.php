@extends('layouts.frontend')

{{--
@section('title'){{$post->title}}@endsection
@section('description'){{$post->intro_text}}@endsection
--}}

{{--
    Glossary tooltips loaded in:
    resources/js/vendors/staaky_tipped.js
--}}

@section('fb-tags')
    <x-social-meta
        :title="$post->title"
        :description="$post->intro_text"
        :image="$post->hasMedia('introimage') ?
                $post->getMedia('introimage')[0]->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('structured-data')
    {!! $post->toJsonLdScript() !!}
@endsection

@section('jumbotron')
    @if($post->hasMedia('introimage'))
        <div class="{{--bg-fixed--}} relative bg-cover bg-no-repeat" style="background-image: url('{{$post->getMedia('introimage')[0]->getUrl()}}'); ">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10">
                <h2 class="text-4xl font-bold mb-2 text-white">
                    {{ $post->title }}
                </h2>
                <h3 class="font-avenir text-2xl leading-9 mb-8 text-gray-300 mt-10">
                    {!! $post->intro_text !!}
                </h3>

                @include('partials.post.userDateAndReadingTime', ['textColor' => 'text-white'])

            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute"></div>
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-22 px-10">
        @if(!$post->hasMedia('introimage'))
            <h2 class="mt-2 mb-8 text-3xl leading-8 font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                {{ $post->title }}
            </h2>

            @if(strtolower($post->category->name) == 'blog')
                <div class="my-10">
                    @include('partials.post.userDateAndReadingTime', ['textColor' => 'text-gray-400'])
                </div>
            @endif

            <div class="font-avenir text-2xl leading-9 text-gray-700 mb-5">{!! $post->intro_text !!}</div>
        @endif

        <div class="easyRead font-avenir text-gray-900 text-xl mb-10 leading-9">
            {!! $post->body !!}
        </div>

    </div>
@endsection
