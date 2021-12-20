@extends('layouts.app')

@section('fb-tags')
    <x-social-meta
        :title="$organizer->name . ' ' . $organizer->surname"
        :image="$organizer->hasMedia('profile_picture') ?
                $organizer->getMedia('profile_picture')->first()->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg max-w-prose mx-auto mb-6 mt-8 sm:mt-32 px-10 text-gray-500">
        <h1>
            {{ $organizer->name }} {{ $organizer->surname }}
        </h1>
        <div class="text-sm">
            {{-- Phone --}}
            <div class="flex items-center">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" clip-rule="evenodd"/></svg>
                <div>{{$organizer->phone}}</div>
            </div>
            <div class="sm:flex">
                {{-- Email --}}
                <div class="flex items-center mt-2 sm:w-1/2">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <div><a class="textLink" href="mailto:{{ $organizer->email }}">{{ $organizer->email }}</a></div>
                </div>
                {{-- Website --}}
                <div class="flex items-center mt-2 sm:w-1/2">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/></svg>
                    <div><a class="textLink" href="{{ $organizer->website }}">Website</a></div>
                </div>
            </div>
        </div>
        {{-- Description --}}
        <div>
            <h3>Description</h3>
            <div>
                @if($organizer->hasMedia('profile_picture'))
                    <img class="rounded-lg shadow-lg mb-2 sm:float-right sm:ml-3" src="{{ $organizer->getMedia('profile_picture')->first()->getUrl('thumb') }}"
                         alt="{{ $organizer->name }} {{ $organizer->surname }} picture">
                @endif
                <p>{!! $organizer->description !!}</p>
            </div>
        </div>
    </div>

@endsection
