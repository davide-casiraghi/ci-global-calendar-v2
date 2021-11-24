{{--
<div class="space-y-4 sm:grid sm:grid-cols-3 sm:gap-6 sm:space-y-0 lg:gap-8 p-3">
    <div class="h-0 aspect-w-3 aspect-h-2 sm:aspect-w-3 sm:aspect-h-4">
        <img class="object-cover shadow-lg rounded-lg" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">
    </div>
    <div class="sm:col-span-2">
        <div class="space-y-4">
            <div class="text-lg leading-6 font-medium space-y-1">
                <h3>Whitney Francis</h3>
                <p class="text-indigo-600">Copywriter</p>
            </div>
            <div class="text-lg">
                <p class="text-gray-500">Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.</p>
            </div>
        </div>
    </div>
</div>
--}}

<div class="mb-10 lg:mb-0">
    <blockquote class="col-span-3 md:col-span-1 rounded-md shadow-xl overflow-hidden bg-white">
        <div class="flex-grow flex items-center p-6 text-lg leading-relaxed text-gray-500">
            <p class="">
                {{$testimonial->feedback_short}}
            </p>
        </div>

        <footer class="z-20 px-6 py-3 bg-gray-200">
            <a href="{{route('testimonials.show', $testimonial->id)}}" target="_blank" rel="noopener" class="flex items-center group">
                    <span class="mr-3 w-12 h-12 rounded-full overflow-hidden shadow">
                        @if($testimonial->getMedia('photo')->first())
                            <img alt="{{$testimonial->name}} {{$testimonial->surname}} avatar" class="w-12 h-12 object-cover rounded-full overflow-hidden"
                                 src="{{$testimonial->getMedia('photo')->first()->getUrl('thumb')}}">
                        @endif
                    </span>
                <span class="leading-snug">
                    <span class="block font-semibold uppercase tracking-widest | group-hover:text-dark-700">{{$testimonial->name}} {{$testimonial->surname}}</span>
                    <span class="block text-xs text-dark-500">{{$testimonial->profession}}, {{$testimonial->country->name}}</span>
                </span>
            </a>
        </footer>
    </blockquote>
</div>
