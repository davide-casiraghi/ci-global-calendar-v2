@extends('layouts.app')

@section('content')
    {{--<h2 class="text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
        Blog - https://land-book.com/websites/16074-media
    </h2>--}}
    <div class="flex flex-wrap mb-4 pt-4">
        <div class="w-full sm:w-3/5 text-center pr-4">
            <img class="h-64 w-full mb-4" src="https://source.unsplash.com/random/800x600" alt="">
            <div class="text-xs uppercase">1 How hr tems are addressing corona virus</div>
            <div class="text-lg font-bold">How hr tems are addressing corona virus</div>
            <div class="text-sm">How hr tems are addressing corona virus How hr tems are addressing corona virus</div>
        </div>
        <div class="w-full sm:w-2/5 border-solid border-l-2 border-gray-300 p-4">
            <h4 class="text-lg font-extrabold border-solid border-b-2 border-gray-300 pb-4">Spotlights</h4>

            <div class="border-solid border-b-2 border-gray-300 py-4 flex">
                <div class="w-4/5">
                    <div class="uppercase text-xs">category</div>
                    <div class="text-lg font-bold">Title</div>
                    <div class="text-small text-gray-400">6 min read</div>
                </div>
                <div class="w-1/5">
                    <img class="w-full rounded-lg" src="https://source.unsplash.com/random/800x600" alt="">
                </div>
            </div>

            <div class="border-solid border-b-2 border-gray-300 py-4 flex">
                <div class="w-4/5">
                    <div class="uppercase text-xs">category</div>
                    <div class="text-lg font-bold">Title</div>
                    <div class="text-small text-gray-400">Nov 8, 2020 - Less then one minute read</div>
                </div>
                <div class="w-1/5">
                    <img class="w-full rounded-lg" src="https://source.unsplash.com/random/800x600" alt="">
                </div>
            </div>

            <div class="border-solid border-b-2 border-gray-300 py-4 flex">
                <div class="w-4/5">
                    <div class="uppercase text-xs">category</div>
                    <div class="text-lg font-bold">Title</div>
                    <div class="text-small text-gray-400">6 min read</div>
                </div>
                <div class="w-1/5">
                    <img class="w-full rounded-lg" src="https://source.unsplash.com/random/800x600" alt="">
                </div>
            </div>
        </div>
    </div>


    <div class="lastTweets border-solid border-t-2 border-gray-300">
        <h4 class="text-lg font-extrabold my-4">Latest tweets</h4>
        {{--<p>Twitter posts like here: https://blog.v.vodafone.com/</p>--}}

        <div class="flex mb-4 gap-x-4 mt-4">
            <div class="w-full md:w-1/4 p-2 bg-gray-400 text-center">twitter post</div>
            <div class="w-full md:w-1/4 p-2 bg-gray-500 text-center">twitter post</div>
            <div class="w-full md:w-1/4 p-2 bg-gray-400 text-center">twitter post</div>
            <div class="w-full md:w-1/4 p-2 bg-gray-400 text-center">twitter post</div>
        </div>
    </div>



    <div class="px-4 py-2 mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">

        @foreach($posts as $post)
            @include('partials.pages.home.blog.block_post')
        @endforeach
    </div>

    <div class="my-5">
        {{ $posts->links() }}
    </div>




@endsection
