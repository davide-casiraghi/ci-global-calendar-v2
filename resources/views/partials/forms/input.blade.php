{{--
    INPUT form field

    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
        - $placeholder: string - the placeholder to show when no date selected
        - $tooltip: string - the content of the tooltip
        - $value: the already stored value (used in edit view to retrieve the already stored value)
        - $hide: if true
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<input type="text"
       @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset

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

{{--



<div class="form-group {{ $name }}" @if( !empty($hide)) style="display:none;" @endif>
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif

    <input type="text" name="{{ $name }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
           @if(!empty($placeholder)) placeholder="{{ $placeholder }}" aria-label="{{ $placeholder }}" @endif
           @if(!empty($value)) value="{{ $value }}" @endif
    >

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
--}}
