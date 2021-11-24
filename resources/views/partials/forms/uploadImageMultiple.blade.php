{{--

    UPLOAD IMAGE MULTIPLE

    NOTICE:
        - uses the js in /resources/js/forms/uploadImageMultiple.js
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

    {{--<div class="flex flex-wrap space-x-4 mt-1 mb-4">
        @foreach($entity->getMedia($collection) as $image)
            <div class="w-44">
                <img src="{{$image->getUrl('thumb')}}" class="" alt="">
            </div>
        @endforeach
    </div>--}}

    @livewire('gallery-images-parameters', [
        'model' => $model,
    ])

</div>
<input type="file" class="form-control-file" name="{{$name}}[]" placeholder="{{$name}}" multiple>

