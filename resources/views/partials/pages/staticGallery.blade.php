<div class='lifeGallery'>
    @foreach($images as $image)

        <div class="item transform transition hover:scale-110 motion-reduce:transform-none duration-500">
            @php
                $imageLink = $path.$image['name'];
                $thumbLink = $path."thumb/".$image['name'];
                $isVideo = false;

                if (array_key_exists('youtube_url',$image)){
                  $imageLink = $image['youtube_url'];
                  $isVideo = true;
                }
                if(array_key_exists('vimeo_url',$image)){
                  $imageLink = $image['vimeo_url'];
                  $isVideo = true;
                }

                $caption = '';
                if(array_key_exists('description',$image)){
                  $caption = $image['description'].'<br>';
                }
                if(array_key_exists('credits',$image)){
                  $caption = $image['credits'];
                }
            @endphp

            <a href='{{asset($imageLink)}}' data-fancybox='images' @if(!empty($caption))data-caption='{{$caption}}'@endif>
                <img src='{{asset($thumbLink)}}' @if(array_key_exists('description',$image)) alt='{{$image['description']}} @endif' />
                @if($isVideo)
                    <div>
                        <svg class='absolute w-14 fill-current text-white inset-center opacity-80' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M371.7 238l-176-107c-15.8-8.8-35.7 2.5-35.7 21v208c0 18.4 19.8 29.8 35.7 21l176-101c16.4-9.1 16.4-32.8 0-42zM504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256z'/></svg>
                    </div>
                @endif
            </a>
            @if(array_key_exists('description',$image))
                <div class="jg-caption">
                    {{$image['description']}}
                </div>
            @endif
        </div>
    @endforeach
</div>
