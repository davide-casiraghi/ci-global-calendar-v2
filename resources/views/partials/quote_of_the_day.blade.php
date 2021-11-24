<blockquote class="bg-gray-100 flex flex-col mb-8 mx-10 sm:mx-0">
    <div class="relative py-3 max-w-xl mx-auto">
        <h3 class="text-3xl text-center text-gray-700 font-bold">Quote of the day</h3>

        {{--<div class="text-center mt-28 mb-14 text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none sm:text-6xl lg:text-4xl xl:text-5xl">
            Quote of the day
        </div>--}}

        @isset($quote)
            <div>
                <div class="text-6xl text-primary-500 text-left leading-tight h-3 font-serif mb-6" aria-hidden="true">“</div>
                <div class="text-center text-xl italic text-gray-500">
                    {{$quote->description}}
                </div>
                <div class="text-4xl text-primary-500 text-right leading-tight h-3 font-serif" aria-hidden="true">”</div>
            </div>
            <cite>
                <div class="text-md text-primary-500 font-bold text-center mt-3">
                    {{$quote->author}}
                </div>
            </cite>
        @endisset
        @if(empty($quote))
            <p>No quotes found</p>
        @endif
    </div>
</blockquote>

