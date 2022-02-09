{{--
    The colors are defined as classes here: resources/sass/_messages.scss
--}}
<div class="px-10">
    <div class="contextualFeedback {{$color}} rounded-lg py-5 px-6 text-base {{$extraClasses}}" role="alert">
        {!! $message !!}
    </div>
</div>




