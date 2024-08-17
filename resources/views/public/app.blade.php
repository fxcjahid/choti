<!DOCTYPE html>
<html lang="bn">

<head>
    {!! Meta::toHtml() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ mix('assets/public/css/app.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LV49BCJ8JT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LV49BCJ8JT');
    </script>
</head>

<body class="2xl:m-auto 2xl:max-w-screen-2xl">
    @include('public.components.header')
    @yield('content')
    @include('public.components.footer')
</body>
<script src="{{ mix('assets/public/js/app.js') }}"></script>

{!! GoogleReCaptchaV3::init() !!}

</html>
