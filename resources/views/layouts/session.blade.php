<!DOCTYPE html>
<html style="font-size: 36px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Present</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    @livewireStyles

    @stack('head')
</head>
<body class="overflow-hidden text-gray-100">
@yield('content')

@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>
@stack('app')
</body>
</html>
