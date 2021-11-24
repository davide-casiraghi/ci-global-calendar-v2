<div class="">
    <div class="container max-w-4xl mx-auto px-8 lg:px-0 relative header-image-sm sm:header-image xl:no-header-image">
        <nav class="grid sm:grid sm:grid-cols-6 text-primary-600 pt-8 pb-6">  {{--flex justify-between--}}
            {{--<div class="font-brand text-3xl">
                <a href="/">MML</a>
            </div>--}}
            <div class="sm:col-span-2 font-medium z-10 block text-center sm:text-left font-semibold mb-4 sm:mb-0">
                <a href="/" class="pr-8">
                    <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
                {{--<a href="{{route('staticPages.aboutMe')}}" class="pr-8">@lang('static_pages.top_menu.about_me')</a>--}}
            </div>
            <div class="sm:col-span-4 font-medium z-10 block text-center sm:text-right font-semibold">
                {{--<a href="{{route('staticPages.treatments')}}" class="pr-8">@lang('static_pages.top_menu.treatments')</a>--}}
                <a href="{{route('events.next')}}" class="pr-8">@lang('static_pages.top_menu.events')</a>
                <a href="{{route('posts.blog')}}" class="pr-8">@lang('static_pages.top_menu.blog')</a>
            </div>
        </nav>

        {{--<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            <div class="">aaa</div>
            <div class="">bbbb</div>
            <div class="">ccc</div>
        </div>--}}
    </div>
</div>