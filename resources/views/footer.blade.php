
@php
    $made_with_love_string = sprintf(__('views.made_with_love'), "❤️");
@endphp

<footer class="bg-gray-800 text-white z-40 py-5">

    <div class="md:grid md:grid-cols-6">
        <div class="md:col-span-3">
            {!! $made_with_love_string !!}
        </div>
        <div class="md:col-span-3 mt-3 md:mt-0">
            Send us a feedback
        </div>
    </div>
</footer>
