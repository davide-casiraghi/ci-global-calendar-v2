
@php
    $made_with_love_string = sprintf(__('views.made_with_love'), "🤍️");
@endphp

<footer class="bg-calendarGold text-white relative z-20 h-14 md:flex md:items-stretch justify-between">
    <div class="flex items-center p-4">
        {!! $made_with_love_string !!}
    </div>
    <div class="mt-3 md:mt-0 flex inline-block justify-end items-center items-stretch">
        <a href="#" class="p-4 cursor-pointer hover:bg-calendarGoldHover flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <div class="ml-1">
                @lang('general.send_a_feedback')
            </div>
        </a>
    </div>
</footer>


