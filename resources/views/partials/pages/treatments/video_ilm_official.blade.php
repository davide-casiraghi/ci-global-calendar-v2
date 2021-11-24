<div class="mt-10 mb-24 mx-auto max-w-screen-xl p-4 sm:mt-12 sm:px-6 md:mt-20 xl:my-48">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-lg md:mx-auto lg:mx-0 lg:col-span-6 lg:text-left lg:col-start-7 lg:row-start-1 mt-10">
            <h3 class="text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none sm:text-6xl lg:text-5xl">
                @lang('static_pages.treatments.a_breath_of_fresh_air')
            </h3>
            <div class="mt-3 text-gray-500 sm:mt-5 text-xl lg:text-lg xl:text-xl">
                @lang('static_pages.treatments.each_cell')
                <div class="mt-2">
                    <a href="{{route('staticPages.treatmentsLearnMore')}}" class="textLink">@lang('static_pages.treatments.learn_more')</a>
                </div>
            </div>
        </div>
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center lg:col-start-1 lg:row-start-1">
            {{--<div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                <iframe width="100%" height="280" src="https://www.youtube.com/embed/qYkICwE7NaA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>--}}

            <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                <a data-fancybox href="https://www.youtube.com/embed/qYkICwE7NaA">
                    <img class="w-full" src="{{asset('images/static_pages/treatments/ilm_video_cover.jpg')}}" alt="Woman making a sale">
                    {{--<iframe width="450" height="300" src="https://www.youtube.com/embed/MelWoO9J3E8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                        <svg class="h-20 w-20 text-primary-500" fill="currentColor" viewBox="0 0 84 84">
                            <circle opacity="0.9" cx="42" cy="42" r="42" fill="white" />
                            <path d="M55.5039 40.3359L37.1094 28.0729C35.7803 27.1869 34 28.1396 34 29.737V54.263C34 55.8604 35.7803 56.8131 37.1094 55.9271L55.5038 43.6641C56.6913 42.8725 56.6913 41.1275 55.5039 40.3359Z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>











