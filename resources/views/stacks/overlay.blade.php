<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Preview</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <style>
        {!! $overlay->stack->theme->css !!}
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.style.zoom = window.innerWidth / 1920;
        });
    </script>
</head>
<body class="{{ request('bg') == "white" ? "bg-white" : "" }} overflow-hidden text-gray-100">
    <div class="slide {{ $overlay->css_classes }} {{ $overlay->layout }} {{ $overlay->size }}">
        <div class="inner">{!! $overlay->final !!}</div>
    </div>
</body>
</html>
