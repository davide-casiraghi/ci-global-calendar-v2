{{--
    TEXTAREA with or without tinymce editor.
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when no text present
        - $value: the already stored value (used in edit view to retrieve the already stored value)
        - $style: plain|tinymce
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<div class="mt-1">
    <textarea
            id="{{ $name }}"
            @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset
            rows="3"
            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md
                    @if ($errors->has($name)) border-red-500 @endif
                    @if ($disabled) bg-gray-200 @endif
                    @if ($style == 'tinymce') textarea_tinymce @endif
                    "
            @if(!empty($placeholder))
                placeholder="{{ $placeholder }}"
                aria-label="{{ $placeholder }}"
           @endif
    >{{ $value ?? '' }}</textarea>
    @error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
    @enderror
</div>
@if(!empty($extraDescription))
    <p class="mt-2 text-sm text-gray-500">
        {{$extraDescription}}
    </p>
@endif