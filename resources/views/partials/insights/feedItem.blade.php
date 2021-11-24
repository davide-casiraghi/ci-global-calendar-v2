<li>
    <div class="feedItem relative pb-16">
        {{--connecting line--}}
        @if (!$loop->last)
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
        @endif


        <div class="relative flex items-start space-x-3">
            <div class="relative">
                <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="{{asset('images/static_pages/insights/davide_casiraghi_portrait_2019.jpg')}}" alt="">

                {{-- CHAT ICON
                <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                  <!-- Heroicon name: solid/chat-alt -->
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                  </svg>
                </span>--}}
            </div>
            <div class="min-w-0 flex-1">
                <div>
                    <div class="text-sm font-medium">
                        {{--<a href="#" class="font-medium text-gray-900">{{$insight->title}}</a>--}}
                        {{$insight->title}}
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">
                        {{$insight->created_at->format('M j, Y')}}
                    </p>
                </div>
                <div class="mt-2 text-sm text-gray-700">
                    <p>
                        {!! $insight->body !!}
                    </p>
                </div>
                <div class="tags mt-2">
                    @foreach($insight->tags as $tag)
                        <a href="{{route('tags.show', $tag->slug)}}" class="relative inline-flex items-center rounded-full border border-gray-300 px-3 py-0.5 text-sm">
                            <span class="absolute flex-shrink-0 flex items-center justify-center">
                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                            </span>
                            <span class="ml-3.5 font-medium text-gray-900">{{$tag->tag}}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</li>