{{--
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when nothing is selected
        - $tooltip: string - the content of the tooltip
        - $value: the selected value
        - $record: the content of the selected value
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>

    @if($required)
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    @endif
@endif

<select id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $name }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @if(!empty($placeholder))
        <option value="" class="text-gray-500">{{$placeholder}}</option>
    @endif
    @if(!empty($records))
        @foreach ($records as $key => $record)
            <option value="{{$key}}" @if(isset($selected)) {{  $selected == $key ? 'selected' : '' }}@endif>{{ ucfirst($record) }}</option>
        @endforeach
    @endif
</select>

@error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror

