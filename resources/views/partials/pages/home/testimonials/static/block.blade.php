

{{-- Inspiration https://mailcoach.app/ --}}
{{--
<div class="mt-10">
    <h2 class="text-center mb-10 text-2xl">Testimonials</h2>

    <div class="lg:grid lg:grid-cols-3 lg:gap-4 px-4 lg:px-0 items-stretch justify-center">
        @foreach($testimonials as $testimonial)
            <div class="@if($loop->iteration == 2 || $loop->iteration == 5) mt-8 @endif">
                @include('partials.pages.home.testimonials.block_testimonial')
            </div>
        @endforeach
    </div>
</div>
--}}


<div class="mt-10 mx-4 mb-8">
   <div class="text-center mt-28 mb-14 text-4xl tracking-tight leading-10 font-brand text-gray-900 sm:leading-none sm:text-6xl lg:text-4xl xl:text-5xl">
       @lang('static_pages.home.blocks.testimonials.what_people_are_saying')
   </div>
   <div class="box-border mx-auto md:masonry-2-col lg:masonry-3-col before:box-inherit after:box-inherit">
       @foreach($testimonials as $testimonial)
           <div class=" my-4 bg-gray-200 rounded-lg break-inside">
               @include('partials.pages.home.testimonials.static.block_testimonial')
           </div>
       @endforeach
    </div>
</div>

