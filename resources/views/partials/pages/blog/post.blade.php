<li class="border-gray-400 border-solid border-0 box-border leading-6 py-12 text-left text-black">
    <article class="xl:grid xl:items-baseline xl:grid-cols-4 border-solid box-border text-left">
        <dl class="border-gray-400 border-0 leading-6 m-0 text-black">
            <dt class="sr-only border-solid box-border text-left">
                Published on
            </dt>
            <dd class="border-solid box-border font-medium text-base leading-normal text-left text-gray-600" style="list-style: outside none none; quotes: auto;">
                <time datetime="2021-02-01T13:35:00.0Z" class="border-gray-400 border-0 font-medium leading-6 text-gray-600" style="list-style: outside none none; quotes: auto;">
                    {{$post->created_at->format('M j, Y')}}
                </time>
                {{--
                <div class="mt-8 mr-8">
                    @if($post->hasMedia('introimage'))
                        <img src='{{$post->getMedia('introimage')->first()->getUrl('thumb')}}' />
                    @endif
                </div>
                --}}
            </dd>
        </dl>
        <div class="xl:col-span-3 border-gray-400 border-0 leading-6 text-black">
            <div class="border-solid box-border text-left">
                <h2 class="border-gray-400 border-0 font-bold text-2xl m-0 text-black tracking-tight">
                    <a href="{{route('posts.show', $post->slug)}}" class="bg-transparent border-solid box-border cursor-pointer text-2xl text-left text-gray-900">
                        {{$post->title}}
                    </a>
                </h2>
                <div>
                    @foreach($post->tags as $tag)
                        <a class="textLink mr-1" href="{{route('tags.show', $tag->slug)}}">#{{$tag->tag}}</a>
                    @endforeach
                </div>
                <div class="border-gray-400 border-0 max-w-none">
                    <p class="border-solid box-border leading-7 mx-0 my-5 text-left text-gray-500 text-base">
                        {{$post->intro_text}}
                    </p>

                </div>
            </div>
            <div class="textLink">
                <a href="{{route('posts.show', $post->slug)}}" class="bg-transparent border-gray-400 border-0 cursor-pointer leading-6 text-primary-600 hover:text-primary-700" aria-label='Read "{{$post->title}}"'>
                    Read more →
                </a>
            </div>
        </div>
    </article>
</li>