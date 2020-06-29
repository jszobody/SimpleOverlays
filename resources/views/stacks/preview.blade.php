<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Preview</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <style>
        {!! $stack->theme->css !!}
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.style.zoom = window.innerWidth / 1280;
        });
    </script>
</head>
<body class="bg-white overflow-hidden text-gray-100 text-2xl select-none">
    <div class="slide {{ implode(" ", $overlay->css) }} {{ $overlay->layout }} {{ $overlay->size }}">
        <div class="inner">{!! $overlay->final !!}</div>
    </div>
</body>
</html>
