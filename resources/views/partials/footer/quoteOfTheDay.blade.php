@isset($quote)
    <div class="max-w-xs text-left"> {{-- m-auto text-center xl:text-left --}}
    <div class="text-sm leading-5 font-semibold text-gray-400 tracking-wider uppercase mt-6">
        @lang('static_pages.footer.quote_of_the_day')
    </div>
    <div class="text-base leading-6 text-gray-300 mt-4">
            <div>
                <div class="text-6xl text-gray-500 text-left leading-tight h-3 font-serif mb-6" aria-hidden="true">“</div>
                <div class="text-base italic text-gray-500">
                    {{$quote->description}}
                </div>
                <div class="text-4xl text-gray-500 text-right leading-tight h-3 font-serif" aria-hidden="true">”</div>
            </div>
            <cite>
                <div class="text-md text-gray-500 font-bold mt-3">
                    {{$quote->author}}
                </div>
            </cite>
        {{--@if(empty($quote))
            <p>No quotes found</p>
        @endif--}}
    </div>
</div>
@endisset
