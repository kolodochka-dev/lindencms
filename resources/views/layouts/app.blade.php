<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
   
    <!-- @vite(['resources/cms/css/app.css', 'resources/cms/js/app.js']) -->
    <script src="https://unpkg.com/htmx.org@2.0.4"
        integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/htmx.org@1.9.12/dist/ext/multi-swap.js"></script>

    <link href="{{ asset('vendor/lindencms/cms/assets/app.css') }}" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script> -->
    <script src="{{ asset('vendor/lindencms/cms/assets/app.js') }}" type="module"></script>
</head>

<body hx-ext="multi-swap" class="app">
    @include('cms::layouts.sidebar')

    <div id="content" class="content" hx-boost="true" hx-target="#content"
        hx-swap="innerHTML">
        @yield('content')
    </div>
</body>

</html>