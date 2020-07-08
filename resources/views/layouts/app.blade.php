<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/affcbf7764.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/light.css">

    @livewireStyles

    @stack('head')
</head>
<body class="bg-gray-100 h-screen antialiased leading-relaxed {{ isset($page) ? "page-$page" : "" }}">
    <div id="app">
        <header class="bg-gray-900 shadow pb-32">
            <div class="container mx-auto bg-gray-900 px-6 md:px-0 border-b-2 border-gray-800 py-6">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-200 no-underline">
                            <i class="fad fa-layer-group mr-1 opacity-50"></i> {{ team()->name }}
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline text-gray-300 text-sm p-3"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>

            <nav class="container mx-auto px-6 md:px-2 py-6">
                <a href="/stacks" class=" hover:text-gray-100 font-semibold {{ isset($page) && $page == "stacks" ? "text-gray-100" : "text-gray-400" }}">Stacks</a>
            </nav>
        </header>

        <main class="-mt-32 mb-12">
            @yield('content')
        </main>
    </div>

@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>
@stack('app')
</body>
</html>
