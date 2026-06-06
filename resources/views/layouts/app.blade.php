<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <script src="https://unpkg.com/htmx.org@2.0.4"
        integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4/dist/ext/multi-swap.js"></script>
    
    <link href="{{ asset('vendor/lindencms/cms/assets/app.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/lindencms/cms/assets/app.js') }}"></script>
</head>

<body hx-ext="multi-swap">
    <div class="flex h-screen overflow-hidden">
        @include('cms::layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden bg-white" id="content" hx-boost="true" hx-target="#content"
            hx-swap="innerHTML">
            @yield('content')
        </div>
    </div>
</body>

</html>