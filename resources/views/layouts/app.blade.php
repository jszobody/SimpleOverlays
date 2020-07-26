<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eclipse</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/affcbf7764.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/light.css">

    @stack('head')

    @livewireStyles
</head>
<body class="bg-gray-100 h-screen antialiased leading-relaxed {{ isset($page) ? "page-$page" : "" }}">
    <div id="app">
        <header class="bg-gray-900 shadow pb-32">
            <div class="container mx-auto bg-gray-900 px-6 md:px-0 border-b-2 border-gray-800 py-6">
                <div class="flex items-center justify-center">
                    <div class="mr-6 relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape="open = false">
                        <div @click="open = !open" class="text-xl font-semibold text-gray-200 no-underline cursor-pointer">
                            <i class="fad fa-moon mr-1 opacity-50"></i> {{ team()->name }}
                            <i class="fas fa-caret-down text-sm opacity-50"></i>
                        </div>

                        <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg" style="display: none"
                             x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="rounded-md bg-white shadow-xs text-sm" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <div class="py-1">
                                    @foreach(user()->memberTeams AS $team)
                                        <a href="{{ route('select-team', ['team' => $team]) }}"
                                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 {{ team()->id == $team->id ? "font-bold" : "" }}" role="menuitem">
                                            <span>{{ $team->name }}</span>
                                            @if(team()->id == $team->id)
                                                <i class="fas fa-check text-gray-400 text-sm ml-2 mt-1"></i>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                                <div class="border-t border-gray-100"></div>
                                <div class="py-1">
                                    <a href="{{ route('create-team') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">Create new team</a>
                                </div>
                            </div>
                        </div>
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
                <a href="{{ route('list-stacks') }}" class="mx-4 hover:text-gray-100 font-semibold {{ Route::currentRouteName() == "list-stacks" ? "text-gray-100" : "text-gray-400" }}">Stacks</a>
{{--                <a href="{{ route('list-sessions') }}" class="mx-4 hover:text-gray-100 font-semibold {{ Route::currentRouteName() == "list-sessions" ? "text-gray-100" : "text-gray-400" }}">Sessions</a>--}}
{{--                <a href="{{ route('list-teams') }}" class="mx-4 hover:text-gray-100 font-semibold {{ Route::currentRouteName() == "list-themes" ? "text-gray-100" : "text-gray-400" }}">Themes</a>--}}
{{--                <a href="{{ route('list-teams') }}" class="mx-4 hover:text-gray-100 font-semibold {{ Route::currentRouteName() == "list-transformations" ? "text-gray-100" : "text-gray-400" }}">Transformations</a>--}}
                <a href="{{ route('list-teams') }}" class="mx-4 hover:text-gray-100 font-semibold {{ Route::currentRouteName() == "list-teams" ? "text-gray-100" : "text-gray-400" }}">Teams</a>

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
