@extends('layouts.app')

@section('title'){{$post->title}}@endsection
@section('description'){{$post->intro_text}}@endsection

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

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10">
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

        <div class="easyRead font-avenir text-gray-900 text-xl mb-10 leading-9"> {{-- prose text-gray-500 --}}
            {!! $post->body !!}
        </div>

        {{--@if($post->hasMedia('gallery'))
            <div class='lifeGallery'>
                @foreach($post->getMedia('gallery') as $image)


                <div class='item'>
                    @php $imageLink = $image->getUrl(); @endphp

                    @if($image->hasCustomProperty('youtube_url'))
                        @php $imageLink = $image->getCustomProperty('youtube_url'); @endphp
                    @elseif($image->hasCustomProperty('vimeo_url'))
                        @php $imageLink = $image->getCustomProperty('vimeo_url'); @endphp
                    @endif

                        <a href='{{$imageLink}}' data-fancybox='images' data-caption='{{$image->getCustomProperty('description')}}<br>{{$image->getCustomProperty('credits')}}'>
                            <img src='{{$image->getUrl('thumb')}}' alt='{{$image->getCustomProperty('description')}}' />
                            @if($image->hasCustomProperty('youtube_url') or $image->hasCustomProperty('vimeo_url'))
                                <i class='far fa-play-circle' style="position: absolute;top: calc(50% - 25px);left: calc(50% - 25px); color: hsla(0,0%,100%,.8);font-size: 50px;"></i>
                            @endif
                        </a>
                        @if($image->hasCustomProperty('description'))
                        <div class="jg-caption">
                            {{$image->getCustomProperty('description')}}
                        </div>
                        @endif
                </div>
                @endforeach
            </div>
        @endif--}}

            {{-- test --}}
            {{--<span class='tooltip-example' title="1">One</span>--}}


        {{-- Comments --}}
        @if(strtolower($post->category->name) == 'blog')
            @include('partials.comments.list')
            @include('partials.comments.form')
        @endif
    </div>
@endsection
