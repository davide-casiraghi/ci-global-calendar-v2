@extends('layouts.app')

@section('fb-tags')
    <x-social-meta
        :title="$teacher->name . ' ' . $teacher->surname"
        :image="$teacher->hasMedia('profile_picture') ?
                $teacher->getMedia('profile_picture')->first()->getUrl('facebook') :
                '/storage/logo/fb_logo_cigc_red.jpg'"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('structured-data')
    {!! $teacher->toJsonLdScript() !!}
@endsection

@section('content')

    @include('partials.messages')

    <div class="text-lg mt-10 mb-10 px-10 text-gray-500 mx-auto">
        <div class="max-w-prose mx-auto">
            <div class="whiteBox">
                <h1 class="leading-6 text-2xl font-semibold text-gray-700">
                    {{ $teacher->name }} {{ $teacher->surname }}
                </h1>

                <div class="text-base mt-6">
                    {{-- Country --}}
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path></svg>
                        <div>{{$teacher->country->name}}</div>
                    </div>
                    <div class="sm:flex">
                        {{-- Year start practice --}}
                        <div class="mt-2 sm:w-1/2 text-gray-600">
                            <div class="font-bold">@lang('teacher.year_of_starting_to_practice')</div>
                            <div>{{ $teacher->year_starting_practice }}</div>
                        </div>
                        {{-- Year start teach --}}
                        <div class="mt-2 sm:w-1/2 text-gray-600">
                            <div class="font-bold">@lang('teacher.year_of_starting_to_teach')</div>
                            <div>{{ $teacher->year_starting_teach }}</div>
                        </div>
                    </div>
                    <div class="sm:flex">
                        {{-- Facebook --}}
                        <div class="flex items-center mt-2 sm:w-1/2">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                            <div><a class="textLink" href="{{ $teacher->facebook }}">@lang('teacher.facebook_profile')</a></div>
                        </div>
                        {{-- Website --}}
                        <div class="flex items-center mt-2 sm:w-1/2">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/></svg>
                            <div><a class="textLink" href="{{ $teacher->website }}">@lang('general.website')</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="whiteBox mt-6 p-6">
                {{-- Bio --}}
                <div class="text-gray-500 text-lg">
                    @if($teacher->hasMedia('profile_picture'))
                        <img class="rounded-lg shadow-lg mb-2 sm:float-right sm:ml-3" src="{{ $teacher->getMedia('profile_picture')->first()->getUrl('thumb') }}"
                             alt="{{ $teacher->name }} {{ $teacher->surname }} picture">
                    @endif
                    <p>{!! $teacher->bio !!}</p>
                </div>

                {{-- Significant teachers --}}
                <div class="mt-8">
                    <h3 class="text-gray-600 font-bold mb-3">@lang('teacher.significant_teachers')</h3>
                    <div class="text-gray-500 text-lg">
                        {{ $teacher->significant_teachers }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Future teacher events --}}
        <div class="max-w-5xl mt-12">
            <h2 class="leading-6 text-2xl font-semibold text-gray-700">
                @lang('teacher.teacher_will_teach_in_these_events')
            </h2>
            <div class="mt-6">
                @include('partials.events.list', ['events' => $futureTeacherEvents])
            </div>
        </div>

    </div>

@endsection