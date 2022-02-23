
@php
    $made_with_love_string = sprintf(__('views.made_with_love'), "🤍️");
@endphp

<div class="bg-calendarGold text-white relative z-20 md:flex md:items-stretch justify-between">
    <div class="flex items-center p-4">
        {!! $made_with_love_string !!}
    </div>
    <div class="mt-3 md:mt-0 flex inline-block justify-end items-center items-stretch">
        @livewire('modals.feedback-message')
    </div>
</div>