{{-- Global site tag (gtag.js) - Google Analytics --}}
@env('production')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-E8J8KSDTGD"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-E8J8KSDTGD');
    </script>
@endenv
