
<div class="mt-10 mx-4 mb-12">
    <div class="text-center mt-28 mb-14 text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none sm:text-6xl lg:text-4xl xl:text-5xl">
        @lang('static_pages.home.blocks.testimonials.what_people_are_saying')
    </div>

    <div class="testimonialsList w-11/12 mx-auto"> {{-- w-11/12 means with 90% width to leave spaces for < > arrows--}}
        @foreach($testimonials as $testimonial)
            <div class="mb-8 rounded-lg break-inside p-2">
                @include('partials.pages.home.testimonials.slick.block_testimonial')
            </div>
        @endforeach
    </div>
</div>



