{{--
    TimePicker form field.

    Vanilla Javascript Timepicker
    by Lance Jernigan
    https://codepen.io/Lance-Jernigan/pen/jARLLO


    The custom JS for this field is defined in:
    resources/js/vendors/timepicker.js

    PARAMETERS:
        - $class: string - the class related to the js that activate the datepicker
        - $label: optional label to show above the field
        - $placeholder
        - $name: input the field name
        - $value: the value of the field
        - $endDate: To set a limit to the selectable days eg. '+1y'

--}}




@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

{{--
<input
        type="text"
        class="timepicker focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md mt-2"

        name="{{ $name }}"
        id="{{ $name }}"
        @if(!empty($value)) value="{{ $value }}" @endif

/>--}}

<div class="">
    <div class="inline shadow-sm sm:text-sm rounded-md border-gray-300 border-solid border p-2">
        <select name="{{$name}}Hours" class="bg-transparent appearance-none outline-none border-none">
            <option value="">...</option>
            <option value="1" {{  $value['hours'] == '1' ? 'selected' : '' }}>1</option>
            <option value="2" {{  $value['hours'] == '2' ? 'selected' : '' }}>2</option>
            <option value="3" {{  $value['hours'] == '3' ? 'selected' : '' }}>3</option>
            <option value="4" {{  $value['hours'] == '4' ? 'selected' : '' }}>4</option>
            <option value="5" {{  $value['hours'] == '5' ? 'selected' : '' }}>5</option>
            <option value="6" {{  $value['hours'] == '6' ? 'selected' : '' }}>6</option>
            <option value="7" {{  $value['hours'] == '7' ? 'selected' : '' }}>7</option>
            <option value="8" {{  $value['hours'] == '8' ? 'selected' : '' }}>8</option>
            <option value="9" {{  $value['hours'] == '9' ? 'selected' : '' }}>9</option>
            <option value="10" {{  $value['hours'] == '10' ? 'selected' : '' }}>10</option>
            <option value="11" {{  $value['hours'] == '11' ? 'selected' : '' }}>11</option>
            <option value="12" {{  $value['hours'] == '12' ? 'selected' : '' }}>12</option>
        </select>
        <span class="text-xl px-1 pt-1">:</span>
        <select name="{{$name}}Minutes" class="bg-transparent appearance-none outline-none border-none">
            <option value="">...</option>
            <option value="00" {{  $value['minutes'] == '00' ? 'selected' : '' }}>00</option>
            <option value="15" {{  $value['minutes'] == '15' ? 'selected' : '' }}>15</option>
            <option value="30" {{  $value['minutes'] == '30' ? 'selected' : '' }}>30</option>
            <option value="45" {{  $value['minutes'] == '45' ? 'selected' : '' }}>45</option>
        </select>
        <select name="{{$name}}Ampm" class="bg-transparent appearance-none outline-none border-none">
            <option value="">...</option>
            <option value="am" {{  $value['ampm'] == 'AM' ? 'selected' : '' }}>AM</option>
            <option value="pm" {{  $value['ampm'] == 'PM' ? 'selected' : '' }}>PM</option>
        </select>
    </div>
</div>