
@php
    $made_with_love_string = sprintf(__('views.made_with_love'), "❤️");
@endphp

<footer class="bg-calendarGold text-white relative z-20 p-5">

    <div class="md:grid md:grid-cols-6">
        <div class="md:col-span-3">
            {!! $made_with_love_string !!}
        </div>
        <div class="md:col-span-3 mt-3 md:mt-0 flex inline-block justify-end">
            <a href="#" class="cursor-pointer hover:bg-gray-200 hover:text-gray-800">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <div class="ml-1">
                        Send us a feedback
                    </div>
                </div>
            </a>
        </div>
    </div>
</footer>
