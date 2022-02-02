@isset($message)
<div class="homepageMessage">
    @if($showHomepageMessage)
        <div class="{{$message->color}} rounded-lg py-5 px-6 text-base z-20 relative max-w-3xl m-auto mt-10" role="alert">
            <button wire:click="close" type="button" class="float-right rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="sr-only">Close</span>
                <!-- Heroicon name: x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            @if($message->show_title)
                <h3 class="font-bold mb-2">{{$message->title}}</h3>
            @endif


            {!! $message->body !!}
        </div>
    @endif
</div>
@endisset
