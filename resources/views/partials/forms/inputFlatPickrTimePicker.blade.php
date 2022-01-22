{{--
    Flatpikr DateTimePicker form field.
    https://flatpickr.js.org/

    The custom JS for this field is defined in:
    resources/js/vendors/flatpickr.js

    PARAMETERS:
        - $class: string - the class related to the js that activate the datepicker
        - $label: optional label to show above the field
        - $placeholder
        - $name: input the field name
        - $value: the value of the field
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    {{-- Required (Tooltip) --}}
    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<div class="relative rounded-md shadow-sm">
    <input
            @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset
            id="{{ $name }}"
            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm
                        border-gray-300 rounded-md mt-1
                        @if($disabled) bg-gray-200 @endif {{$class}}"
            tabindex="0"
            type="text"
            @if(!empty($value)) value="{{ $value }}" @endif
            placeholder="{{$placeholder}}"
            readonly="readonly"
            aria-describedby="{{ $name }}"
            aria-label="Enter date"
            @if($disabled)
            disabled
            @endif
    >
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
        </svg>
        {{--<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
        </svg>--}}
    </div>
</div>

