@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('content')

    <!-- STATS -->
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Last 30 days
        </h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg relative">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Insights
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{--{{$totalInsights}}--}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>

            <div class="relative bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Posts
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{$totalPosts}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>

            <div class="relative bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Testimonials
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{--{{$totalTestimonials}}--}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>
        </dl>
    </div>


    <div class="mt-8">
        <div class="md:grid md:grid-cols-6 md:gap-6">

            {{-- Glossary terms to complete --}}
            <div class="md:col-span-2">
                <h2 class="mb-4">Glossary terms to complete</h2>
                {{--<ul class="bg-white overflow-hidden shadow rounded-lg p-6">
                    @forelse($unpublishedGlossaryTerms as $glossaryTerm)
                        <li><a class="textLink" href="{{route('glossaries.edit', $glossaryTerm->id)}}">{{$glossaryTerm->term}}</a></li>
                    @empty
                        <li>There are not glossary terms to complete.</li>
                    @endforelse
                </ul>--}}
            </div>

            {{-- Latest insights --}}
            <div class="md:col-span-4">
                {{--<div class="mb-4">
                    <h2 class="mb-4">Inspiration</h2>
                    <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                        <div class="italic mb-2">{{$quote->description}}</div>
                        {{$quote->author}}
                    </div>
                </div>

                <div>
                    <h2 class="mb-4">Latest insights</h2>
                    <ul class="bg-white overflow-hidden shadow rounded-lg p-6">
                        @forelse($latestInsights as $insight)
                            <li><a class="textLink" href="{{route('insights.edit', $insight->id)}}">{{$insight->title}}</a></li>
                        @empty
                            <li>There are no insights</li>
                        @endforelse
                    </ul>
                </div>--}}
            </div>
        </div>
    </div>
@endsection
