@extends('layouts.app')

@section('title')@lang('post.blog_title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 md:mt-6">

        <div class="leading-6 pt-6 pb-8 text-black border-b border-solid border-gray-200">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Latest
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                All the latest news from the blog.
            </p>
        </div>

        <ul class="divide-y divide-gray-200 border-b border-solid border-gray-200 mb-8">
            @forelse($posts as $post)
                @include('partials.pages.blog.post')
            @empty
                <li>No posts found</li>
            @endforelse
        </ul>

        <div class="my-5">
            {{ $posts->links() }}
        </div>

    </div>

@endsection
