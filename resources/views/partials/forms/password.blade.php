{{--
    INPUT PASSWORD form field

    PARAMETERS:
        - $label: string - the title to show
        - $name: string - the table field name
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<input type="password"
       name="{{ $name }}"
       id="{{ $name }}"
       autocomplete="{{ $name }}"
       @if(!empty($placeholder))
       placeholder="{{ $placeholder }}"
       aria-label="{{ $placeholder }}"
       @endif
       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md
              border-gray-300 @if ($errors->has($name)) border-red-500 @endif
       @if($disabled) bg-gray-200 @endif"
       value="{{ $value ?? '' }}"
       @if($disabled)
       disabled
        @endif
>

@error($name)
<span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror