@section('javascript-document-ready')
    @parent



@stop

<div class="mt-4">
    <span class="text-gray-700">@lang('event.repeat_type')</span>

    <div class="mt-2 repeatController">
        <label class="inline-flex items-center">
            <input type="radio" class="form-radio" name="repeat_type" value="1" @if(empty($event->repeat_type)) {{ 'checked' }} @else {{ $event->repeat_type == 1 ? 'checked' : '' }} @endif>
            <span class="ml-2">@lang('event.no_repeat')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="2" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.weekly')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="3" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.monthly')</span>
        </label>
        <label class="inline-flex items-center ml-6">
            <input type="radio" class="form-radio" name="repeat_type" value="4" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 4 ? 'checked' : '' }}@endif>
            <span class="ml-2">@lang('event.multiple')</span>
        </label>
    </div>
</div>

<div class="repeatDetails hidden mt-4">

    {{-- Weekly --}}
    <div id="onWeekly" class="onFrequency hidden">
        <label>@lang('event.weekly_on')</label>
        <div class="relative flex flex-wrap items-start mt-2">
            {{--<label class="btn btn-primary" id="day_1" >
                <input type="checkbox" name="repeat_weekly_on_day[]" value="1" autocomplete="off"> @lang('general.monday')
            </label>--}}

            @php
                $repeatWeeklyOn = isset($event->repeat_weekly_on) ? explode(',', $event->repeat_weekly_on) : [];
                $checked = in_array(1, $repeatWeeklyOn) ? "checked" : "";
            @endphp

           {{-- {{dd(explode(',', $event->repeat_weekly_on))}}--}}

           {{-- {{json_decode($event->repeat_weekly_on, true)[1]}}--}}
            @include('partials.forms.checkbox', [
                'label' => __('general.monday'),
                'id'  => 'day_1',
                'name' => 'repeat_weekly_on[1]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(2, $repeatWeeklyOn)  ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.tuesday'),
                'id'  => 'day_2',
                'name' => 'repeat_weekly_on[2]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(3, $repeatWeeklyOn) ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.wednesday'),
                'id'  => 'day_3',
                'name' => 'repeat_weekly_on[3]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(4, $repeatWeeklyOn) ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.thursday'),
                'id'  => 'day_4',
                'name' => 'repeat_weekly_on[4]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(5, $repeatWeeklyOn) ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.friday'),
                'id'  => 'day_5',
                'name' => 'repeat_weekly_on[5]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(6, $repeatWeeklyOn) ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.saturday'),
                'id'  => 'day_6',
                'name' => 'repeat_weekly_on[6]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])

            @php
                $checked = in_array(7, $repeatWeeklyOn) ? "checked" : "";
            @endphp
            @include('partials.forms.checkbox', [
                'label' => __('general.sunday'),
                'id'  => 'day_7',
                'name' => 'repeat_weekly_on[7]',
                'checked' => $checked,
                'size' => 'small',
                'required' => false,
            ])
        </div>
        {{--<input type="hidden" name="repeat_weekly_on" id="repeat_weekly_on" @if(!empty($event->repeat_weekly_on))  value="{{$event->repeat_weekly_on}}" @endif/>--}}
    </div>

    {{-- Monthly --}}
    <div id="onMonthly" class="onFrequency hidden">
        {{--<label>@lang('event.monthly') *</label>
        <select name="on_monthly_kind"
                id="on_monthly_kind"
                class="selectpicker"
                title="@lang('general.select_repeat_monthly_kind')"
                placeholder="Select start date first">
        </select>--}}

        @include('partials.forms.select', [
                'label' => __('general.select_repeat_monthly_kind'),
                'name' => 'on_monthly_kind',
                'placeholder' => 'Select start date first',
                'records' => '',
                'selected' => '',
                'required' => TRUE,
                'extraClasses' => '',
            ])


        <input type="hidden" name="on_monthly_kind_value" @if(!empty($event->on_monthly_kind))  value="{{$event->on_monthly_kind}}" @endif/>
    </div>

    <div id="onMultiple" class="onFrequency hidden">
        @include('partials.forms.inputFlatPickrDatePicker',[
                    'class' => 'flatpickr date multiple',
                    'name' => 'multiple_dates',
                    'label' =>  __('event.multiple_dates'),
                    'placeholder' => __('event.select_multiple_dates'),
                    'value' => $eventDateTimeParameters['multipleDates'],
                    'endDate' => '+1y',
                    'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                    'tooltipText' => __('event.select_multiple_dates'),
                    'required' => false,
                    'disabled' => false,
                ])
    </div>

    <div class="hidden repeatUntilSelector mt-4">
        {{--
        @include('partials.forms.inputDatePicker', [
                  'class' => 'datepicker all',
                  'label' => __('event.repeat_until'),
                  'name' => 'repeat_until',
                  'placeholder' => __('views.select_date'),
                  'value' => $eventDateTimeParameters['repeatUntil'],
                  'endDate' => '+1y',
                  'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                  'tooltipText' => __('laravel-events-calendar::event.max_until'),
                  'required' => true,
                  'disabled' => false,
            ])
            --}}
        @include('partials.forms.inputFlatPickrDateTimePicker', [
            'class' => 'flatpickr date all',
            'label' => __('event.repeat_until'),
            'placeholder' => __('views.select_date'),
            'name' => 'repeat_until',
            'value' => old('repeat_until', $eventDateTimeParameters['repeatUntil']),
            'required' => true,
            'disabled' => false,
        ])
    </div>


</div>