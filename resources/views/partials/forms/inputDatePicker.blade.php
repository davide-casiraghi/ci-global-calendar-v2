{{--
    DatePicker form field.

    Defined using NPM package: bootstrap-datepicker
    https://bootstrap-datepicker.readthedocs.io/en/latest/

    The custom JS for this field is defined in:
    resources/js/vendors/bootstrap-datepicker.js

    PARAMETERS:
        - $class: string - the class related to the js that activate the datepicker
        - $label: optional label to show above the field
        - $placeholder
        - $name: input the field name
        - $value: the value of the field
        - $endDate: To set a limit to the selectable days eg. '+1y'

           //todo
        - $tooltipFontAwesomeClass: string - The font awesome class, eg.fa fa-info-circle
        - $tooltipText: string - text to show in the tooltip
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    {{-- Required (Tooltip) --}}
    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<div class="relative rounded-md shadow-sm {{$class}}" data-date-format="dd-mm-yyyy">
    <input
            @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset
            id="{{ $name }}"
            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm
                    border-gray-300 rounded-md
                    @if($disabled) bg-gray-200 @endif"
            type="text"
            @if(!empty($value)) value="{{ $value }}" @endif
            placeholder="{{$placeholder}}"
            readonly="readonly"
            @if(!empty($endDate)) data-date-end-date="{{ $endDate }}" @endif
            aria-describedby="{{ $name }}"
            aria-label="Enter date"
            @if($disabled)
                disabled
            @endif
    >
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
    </div>
</div>

