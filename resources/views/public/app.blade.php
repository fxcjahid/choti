<!DOCTYPE html>
<html lang="bn">

<head>
    {{-- {!! Meta::toHtml() !!} --}}

    <link rel="shortcut icon" href="{{ asset('assets/public/img/icon.png') }}" type="image/x-icon">

    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')" />
    @endif

    @hasSection('hreflang')
        <link rel="alternate" hreflang="bn" href="@yield('hreflang')" />
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ mix('assets/public/css/app.css') }}" rel="stylesheet">
</head>

<body class="2xl:m-auto 2xl:max-w-screen-2xl">
    @include('public.components.header')
    @yield('content')
    @include('public.components.footer')
</body>
<script src="{{ mix('assets/public/js/app.js') }}"></script>

{!! GoogleReCaptchaV3::init() !!}

</html>
