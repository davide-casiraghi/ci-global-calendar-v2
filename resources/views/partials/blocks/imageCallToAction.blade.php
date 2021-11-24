{{--
    ButtonLink form field

    PARAMETERS:
        - $title:
        - $body:
        - $button_text:
        - $button_url:
        - $image_url:
        - $image_alignment: left|right
--}}

@switch($image_alignment)
    @case('left')
        @php
            $imageAlignmentClass = 'md:flex-row-reverse';
            $imagePaddingClass = 'mr-10';
        @endphp
    @break

    @case('right')
        @php
            $imageAlignmentClass = 'md:flex-row';
            $imagePaddingClass = 'ml-10';
        @endphp
    @break

@endswitch

<section class="text-gray-700 body-font {{$extraClasses}}">
    <div class="flex {{$imageAlignmentClass}}">
        <div class="w-7/12">

            {{-- text-3xl font-extrabold tracking-tight text-gray-900 --}}
            {{-- text-2xl font-bold tracking-tighter text-left text-white lg:text-5xl title-font --}}

            <div class="mb-8 text-2xl font-bold tracking-tighter text-center text-primary-800 lg:text-left lg:text-3xl title-font">
                {{$title}}
            </div>
            <p class="mb-8 leading-relaxed text-center text-lg text-gray-500 lg:text-left lg:text-1xl">
                {{$body}}
            </p>
            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                    <a href="{{$button_url}}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:border-primary-700 focus:ring-primary transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        More about CI
                    </a>
                </div>
                {{--<div class="mt-3 sm:mt-0 sm:ml-3">
                    <a href="{{$button_url}}" class="w-full flex items-center justify-center px-8 py-3 border border-primary-600 text-base leading-6 font-medium rounded-md text-primary-700 bg-white hover:text-primary-600 hover:bg-primary-50 focus:outline-none focus:ring-primary focus:border-primary-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                        More info about ILM
                    </a>
                </div>--}}
            </div>
        </div>
        <div class="w-5/12 {{$imagePaddingClass}}">
            <img class="object-cover object-center rounded-lg" alt="hero" src="{{$image_url}}">
        </div>
    </div>
</section>

