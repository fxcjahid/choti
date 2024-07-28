<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots"
          content="noindex" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link rel="shortcut icon"
          href="{{ asset('assets/admin/img/icon.png') }}"
          type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">
    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('assets/admin/css/admin.css') }}"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
          rel="stylesheet">

    <script type="text/javascript">
        window.FILES = {
            upload_max_filesize: {{ (int) ini_get('upload_max_filesize') }},
            IMAGE: {
                maxWidth: {{ env('Image_Max_Width', 2000) }},
                maxHeight: {{ env('Image_Max_Height', 2000) }},
            }
        }
    </script>
    @routes
</head>

<body class="2xl:m-auto 2xl:max-w-screen-2xl">
    <div id="app"
         x-data="{ isOpenSidebar: true }">
        @yield('content')
    </div>
</body>

<script src="{{ mix('assets/admin/js/admin.js') }}"></script>
<script src="{{ mix('assets/admin/js/preline.js') }}"></script>
<script src="//unpkg.com/alpinejs"></script>

</html>
