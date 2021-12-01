@php ($barsBackground = '#B5A575')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@hasSection('title')@yield('title') - @endif{{ __('general.website_name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{$barsBackground}}"/> {{-- Theming the browser's address bar to match your brand's colors provides a more immersive user experience.--}}
    <meta name="description" content="@hasSection('description')@yield('description')@else @lang('general.website_description')@endif">

    {{-- Facebook tags  --}}
    @yield('fb-tags')

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ url('favicon.png') }}">

    {{-- CSS --}}
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')

    {{-- JS that need to stay in the head --}}
    @yield('javascript-head')

    @livewireStyles

    @include('partials.analytics')

    {{-- SEO Structured Data  --}}
    @hasSection('structured-data')
        @yield('structured-data')
    @endif

    {{-- Blade UI Kit styles --}}
    {{-- @bukStyles --}}
    {{-- End Blade UI Kit styles --}}
</head>

<body class="bg-gray-100">
{{--@livewire('navigation-dropdown')--}}

@include('partials.navigation.navigation')

@hasSection('jumbotron')
    <div class="relative mx-auto">
        @yield('jumbotron')
    </div>
@endif


<div class="content relative mx-auto container max-w-7xl">
    @yield('content')
</div>

@include('footer')

@stack('scripts')
{{-- Load Livewire scripts before Alpine --}}
@livewireScripts

{{-- JS --}}
<script src="{{ asset('js/manifest.js') }}" ></script>
<script src="{{ asset('js/vendor.js') }}" ></script>
<script src="{{ asset('js/app.js') }}" ></script>

@stack('scripts')
@yield('javascript')

<script>
    $(document).ready(function(){
        @yield('javascript-document-ready')
    });
</script>

@stack('modals')

{{--  Blade UI Kit scripts --}}
{{-- @bukScripts --}}
{{--  End Blade UI Kit scripts --}}
</body>

</html>
