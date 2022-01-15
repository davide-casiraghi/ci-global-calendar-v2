{{--
    PARAMETERS:
        - $label: string - the label to show
        - $name: string - the select name attribute
        - $description: string - the description to show under the label
        - $value: the selected value
        - $size: (small, medium, big)
--}}


{{--
Wrap the checkboxes in a
<div class="relative flex items-start">

if you want on multiple lines create many
<div class="relative flex items-start">

othewrise put all of them in the same if you want inline

--}}

@php
    switch ($size) {
    case 'small':
        $sizeClass = 'h-4 w-4';
        break;
    case 'medium':
        $sizeClass = 'h-6 w-6';
        break;
    case 'big':
        $sizeClass = 'h-8 w-8';
        break;
}
@endphp

<div class="mb-1">
    @if (!empty($label))
        <label class="flex items-start mr-6">
            <input id="{{$name}}"
                   @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset
                   type="checkbox"
                   class="focus:ring-indigo-500 {{$sizeClass}} text-indigo-600 border-gray-300 rounded @if ($errors->has($name)) border-red-500 @endif"
                    {{--value="{{$value}}"--}}
                    {{$checked}}
            >
            <span class="ml-2">
                {{$label}}
            </span>
        </label>
        @isset($description)
            <div class="ml-6 text-gray-500 text-sm">
                {{$description}}
            </div>
        @endisset
    @else
        <input id="{{$name}}"
               name="{{$name}}"
               type="checkbox"
               class="focus:ring-indigo-500 {{$sizeClass}} text-indigo-600 border-gray-300 rounded @if ($errors->has($name)) border-red-500 @endif"
                {{--value="{{$value}}"--}}
                {{$checked}}
        >
    @endif

    @error($name)
        <span class="invalid-feedback text-red-500" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @enderror
</div>