{{--
This captcha is implemented using: https://github.com/mewebstudio/captcha
Check JS defined in: resources/js/forms/captcha.js
--}}

@if (!empty($label))
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 inline">{{$label}}</label>
    <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
@endif

<div class="flex mb-2">
    <div class="captchaImage">
        {!! captcha_img() !!}
    </div>
    <button @isset($livewireSupport) wire:click="reloadCaptchaLivewire" @endisset type="button" class="blueButton smallButton ml-2 reloadCaptchaImage" >&#x21bb;</button>
</div>

<input type="text" @isset($livewireSupport) wire:model.lazy="{{ $name }}" @else name="{{ $name }}" @endisset
       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md border-gray-300 @if ($errors->has($name)) border-red-500 @endif">

@error($name)
    <span class="invalid-feedback text-red-500" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@enderror

