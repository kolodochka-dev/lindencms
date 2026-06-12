<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/lindencms/cms/assets/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('vendor/lindencms/cms/assets/app.js') }}" type="module"></script>
</head>

<body>
    @yield('content')
</body>

</html>