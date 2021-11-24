<div class="{{$classes}} relative">
    <a href="{{asset($imageUrl)}}" data-fancybox="images" data-caption='{{$alt}}' alt="{{$alt}}">
        <img src="{{asset($imageThumbnailUrl)}}" /> {{-- Thumbnail --}}
    </a>
    <div class="absolute bottom-0 right-0 p-2 bg-gray-100 opacity-80">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
    </div>
</div>