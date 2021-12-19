{{--

    UPLOAD IMAGE

    NOTICE:
        - uses the js in /resources/js/forms/uploadImage.js
    IMPORTANT:
        - when use this add to the form enctype="multipart/form-data"
          like: <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $value: the already stored value (used in edit view to retrieve the already stored value, in create view can be '')
        - $collection: string - collection of the image (spatie media library), defined in the entity model.
--}}


@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<div class="mt-2 flex items-center">
    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">

        @isset($entity)
            @if(is_null($entity->getMedia($collection)->first()))
                {{-- Show the Placeholder --}}
                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>

            @else
                {{-- Show the Image that has been already stored --}}
                <img class="object-cover h-full w-full" src="{{$entity->getMedia($collection)->first()->getUrl('thumb')}}" alt="">

                {{-- Show the image name to use in the edit view to not delete the image on update --}}
                @include('partials.forms.inputHidden', [
                      'name' => $name.'_delete',
                      'value' => 'false'
                ])

            @endif
        @endisset
    </span>

    <span class="ml-5 rounded-md shadow-sm">
        <label class="py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
            <span class="mt-2 text-base leading-normal">Select a file</span>
            <input type='file' name="{{$name}}" class="hidden custom-file-input" />
        </label>
        @isset($entity)
            @if(!is_null($entity->getMedia($collection)->first()))
            <label class="deleteImage ml-3 py-2 px-3 border border-gray-300 rounded-md text-xs leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                <span class="mt-2 text-base leading-normal">
                    <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Delete image
                </span>
            </label>
            @endif
        @endisset
        <div class="selectedFile inline-block ml-3"></div>
    </span>
</div>