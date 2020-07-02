@push('app')
    <script>
        mousetrap.bind(['right', 'down', 'space'], function (e, combo) {
            @this.call('next');
        });

        mousetrap.bind(['left', 'up'], function (e, combo) {
            @this.call('previous');
        });

        mousetrap.bind(['b'], function (e, combo) {
        @this.call('toggle');
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById("selectedThumb").scrollIntoView({inline: "center"});
        });

        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('afterDomUpdate', function () {
                document.getElementById("selectedThumb").scrollIntoView({inline: "center"});
            });
        });
    </script>
@endpush
<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="border-b border-gray-300 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-3xl font-semibold">{{ $stack->title }} </h1>
                <div class="text-gray-500 ml-4"><i
                        class="fad fa-layer-group"></i> {{ $stack->overlays->count() }} {{ Str::plural('overlay', $stack->overlays->count()) }}
                </div>
            </div>
        </div>
        @include("stacks._nav", ['selected' => "present"])
    </div>

    <div>
        <div class="text-xl font-bold mb-2">{{ $session->slug }}</div>
        <div class="flex items-center">
            <i class="fad fa-camera-movie mr-2 text-gray-600"></i>
            <a class="text-blue-500 hover:underline text-sm" href="{{ route('public-play', ['slug' => $session->slug]) }}" target="_blank">{{ route('public-play', ['slug' => $session->slug]) }}</a>
        </div>

        <div class="flex items-center my-8">
            <div class="w-2/3 pr-4">
                <div class="font-bold text-gray-500 mb-4">{{ $stack->overlays->getIndex($current) + 1 }} of {{ $stack->overlays->count() }}</div>
                <div style="background-image: url(/images/transparent-pattern.png)">
                    <img wire:click="next()" class="shadow border border-gray-100 cursor-pointer" src="{{ route('view-overlay', ['stack' => $stack, 'overlay' => $current]) }}">
                </div>
            </div>
            <div class="w-1/3 pl-4">
                @if(is_null($next))
                    <div class="font-bold text-gray-500">End</div>
                    <div class="my-4 shadow border border-gray-100">
                        <img class="invisible" src="{{ route('view-overlay', ['stack' => $stack, 'overlay' => $current]) }}">
                    </div>

                @else
                    <div class="font-bold text-gray-500">Next up...</div>
                    <div class="my-4" style="background-image: url(/images/transparent-pattern.png)">
                        <img wire:click="next()" class="shadow border border-gray-100 cursor-pointer" src="{{ route('view-overlay', ['stack' => $stack, 'overlay' => $next]) }}">
                    </div>
                @endif
                <div wire:click="toggle()" class="mt-8 flex items-center justify-center text-xl py-10 cursor-pointer {{ $session->visible ? "border-2 border-gray-500 text-gray-500" : "border-2 border-red-700 bg-red-700 text-white" }}">
                    {{ $session->visible ? "Hide overlays" : "Overlays hidden" }}
                </div>
            </div>
        </div>

        <div class="flex my-8 overflow-x-auto border border-gray-300 px-2 scroll-smooth">
            @foreach($stack->overlays AS $overlay)
                <div id="{{ $current->id == $overlay->id ? "selectedThumb" : "" }}"
                     class="{{ $current->id == $overlay->id ? 'bg-gray-300' : 'bg-white' }}">
                    <div wire:click="jump({{ $overlay->id }})" class="w-56 h-32 border m-2 mb-0 flex-shrink-0 overflow-hidden text-xs p-2 cursor-pointer select-none bg-white {{ $current->id == $overlay->id ? 'border-blue-500' : 'border-gray-300' }}">
                        {{ $overlay->content }}
                    </div>
                    <div class="text-xs ml-2 my-1 {{ $current->id == $overlay->id ? 'text-gray-700' : 'text-gray-400' }}">{{ $loop->index + 1 }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
