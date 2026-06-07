<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/lindencms/cms/assets/app.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/lindencms/cms/assets/app.js') }}"></script>
</head>

<body>
    @yield('content')
</body>

</html>