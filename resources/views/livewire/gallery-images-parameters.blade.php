<div>
    <div class="mt-1 mb-4"> {{-- flex flex-wrap space-x-4 --}}

         @foreach($galleries as $gallery)
             @if($gallery != null)
             <div>
                 <div class="md:grid md:grid-cols-6 md:gap-6">
                     <div class="col-span-2">
                         <h3 class="mb-4 text-xl font-bold tracking-tighter text-center text-blue-800 lg:text-left lg:text-xl">{{$gallery}}</h3>
                    </div>
                    <div class="col-span-4">
                        <div class="select-all text-sm border border-gray-500 bg-gray-100 rounded p-1 overflow-x-hidden whitespace-nowrap">
                            {# gallery name=[{{$gallery}}] hover_animate=[true] #}
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mb-4">
                    @foreach($model->getMedia('images') as $image)
                        @if($image->getCustomProperty('image_gallery') == $gallery)
                            <div class="w-44 relative">
                                <img src="{{$image->getUrl('thumb')}}" class="" alt="">
                                <button wire:click.prevent="edit({{$image->id}})" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 absolute top-1 right-1">
                                    Properties
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach


        {{--No Gallery (images not assigned to a gallery) --}}
        @php
            $imagesWithNoGalleryPresent = false;
        @endphp
        @foreach($model->getMedia('images') as $image)
            @if($image->getCustomProperty('image_gallery') == null)
                @php
                    $imagesWithNoGalleryPresent = true;
                @endphp
            @endif
        @endforeach
        @if($imagesWithNoGalleryPresent)
            <h3 class="mb-4 text-xl font-bold tracking-tighter text-center text-blue-800 lg:text-left lg:text-xl">No Gallery</h3>
            <div class="flex flex-wrap gap-4">
                    @foreach($model->getMedia('images') as $image)
                        @if($image->getCustomProperty('image_gallery') == null)
                            <div class="w-44 relative">
                                <img src="{{$image->getUrl('thumb')}}" class="" alt="">
                                <button wire:click.prevent="edit({{$image->id}})" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 absolute top-1 right-1">
                                    Properties
                                </button>
                            </div>
                        @endif
                    @endforeach
            </div>
        @endif
    </div>



    {{-- MODAL --}}
    <div class="z-10 inset-0 overflow-y-auto @if($showModal) fixed @else hidden @endif">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
              Background overlay, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <!--
              Modal panel, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                    <button wire:click="close" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Close</span>
                        <!-- Heroicon name: x -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class=""> {{-- sm:flex sm:items-start --}}
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-headline">
                            Add image parameters
                        </h3>

                        <div class="mt-2">
                            <label for="image_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <input type="text" wire:model="image_description" id="image_description" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                            </div>
                        </div>

                        <div>
                            <label for="image_video_url" class="block text-sm font-medium text-gray-700 mt-3">Video URL</label>
                            <div class="mt-1">
                                <input type="text" wire:model="image_video_url" id="image_video_url" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                            </div>
                        </div>

                        <div>
                            <label for="image_caption" class="block text-sm font-medium text-gray-700 mt-3">Caption</label>
                            <div class="mt-1">
                                <input type="text" wire:model="image_caption" id="image_caption" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="image_gallery" class="block text-sm font-medium text-gray-700 mt-3">Gallery</label>
                            <div class="mt-1">
                                <input type="text" wire:model="image_gallery" id="image_gallery" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Name of the gallery to assign the image to">
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="snippet" class="block text-sm font-medium text-gray-700 mt-3">Snippet</label>
                            <div class="mt-1">
                                <input type="text" wire:model="snippet" id="snippet" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="save" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button wire:click="close" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>