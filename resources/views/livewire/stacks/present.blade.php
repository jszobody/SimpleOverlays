@push('head')
    <style>
        {!! $stack->theme->css !!}
    </style>
@endpush
@push('app')
    <script>
        let pusher = Echo.join('session.{{ $session->slug }}');

        pusher.listenForWhisper('update', (e) => {
            @this.call('sync');
        });

        const scroller = new Scroller(document.getElementById('thumbs'), {direction: "horizontal"});

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
            scroller.scrollIntoView(document.getElementById("selectedThumb"));
        });

        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('afterDomUpdate', function () {
                updatePreviewZoom();
                scroller.scrollIntoView(document.getElementById("selectedThumb"));

                if(typeof @this.data.temp.sync == 'undefined') {
                    pusher.whisper('update', {});
                }
            });
        });

        document.addEventListener('DOMContentLoaded', updatePreviewZoom);
        window.addEventListener('resize', updatePreviewZoom);
        function updatePreviewZoom() {
            document.getElementById('current').style.zoom = document.getElementById('current-shim').offsetWidth / 1920;
            if(document.getElementById('next')) {
                document.getElementById('next').style.zoom = document.getElementById('next-shim').offsetWidth / 1920;
            }
        }
    </script>
@endpush
<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10">
    @include("stacks._header", ['selected' => "present"])

    <div>
        <div class="text-xl font-bold mb-2">{{ $session->slug }}</div>
        <div class="flex items-center">
            <i class="fad fa-presentation mr-2 text-gray-600"></i>
            <a class="text-blue-500 hover:underline text-sm" href="{{ route('public-view', ['slug' => $session->slug, 'format' => 'html']) }}" target="_blank">{{ route('public-view', ['slug' => $session->slug, 'format' => 'html']) }}</a>
        </div>

        <div class="lg:flex my-8 sticky top-0 md:relative">
            <div class="lg:w-3/5 lg:pr-4 my-2">
                <div class="font-bold text-gray-500 mb-4">{{ $stack->overlays->getIndex($current) + 1 }} of {{ $stack->overlays->count() }}</div>
                <div style="background-image: url({{ asset('images/transparent-pattern.png') }})" class="relative">
                    <div class="preview-container border border-gray-300 relative overflow-hidden text-gray-100 leading-normal" style="background-image: url({{ asset('images/transparent-pattern.png') }})">
                        <img id="current-shim" class="w-full" src="{{ asset('images/shim-1920x1080.png') }}"/>
                        <div id="current" class="absolute inset-0">
                            <div class="slide {{ $current->css_classes }} {{ $current->layout }} {{ $current->size }}">
                                <div class="inner">{!! $current->final !!}</div>
                            </div>
                        </div>
                    </div>
                    <img class="absolute inset-0 cursor-pointer" src="{{ asset('images/shim-1920x1080.png') }}" wire:click="next()" />
                </div>
            </div>
            <div class="hidden sm:block lg:w-2/5 lg:pl-4 my-2 flex flex-wrap lg:flex-col">
                <div class="w-full font-bold text-gray-500">{{ is_null($next) ? "End" : "Next up..." }}</div>
                @if(is_null($next))
                    <div class="w-3/5 lg:w-full my-4 shadow border border-gray-100">
                        <img class="w-full" src="{{ asset('images/shim-1920x1080.png') }}"/>
                    </div>
                @else
                    <div class="w-3/4 lg:w-full my-4 relative" style="background-image: url({{ asset('images/transparent-pattern.png') }})">
                        <div class="border border-gray-300 relative overflow-hidden text-gray-100 leading-normal" style="background-image: url({{ asset('images/transparent-pattern.png') }})">
                            <img id="next-shim" class="w-full" src="{{ asset('images/shim-1920x1080.png') }}"/>
                            <div id="next" class="absolute inset-0">
                                <div class="slide {{ $next->css_classes }} {{ $next->layout }} {{ $next->size }}">
                                    <div class="inner">{!! $next->final !!}</div>
                                </div>
                            </div>
                        </div>
                        <img class="absolute inset-0 cursor-pointer" src="{{ asset('images/shim-1920x1080.png') }}" wire:click="next()" />
                    </div>
                @endif
                <div wire:click="toggle()" class="my-4 lg:mb-px ml-4 lg:ml-0 flex-grow flex items-center justify-center text-xl cursor-pointer {{ $session->visible ? "border-2 border-gray-500 text-gray-500" : "border-2 border-red-700 bg-red-700 text-white" }}">
                    {{ $session->visible ? "Hide overlays" : "Overlays hidden" }}
                </div>
            </div>
        </div>

        <div id="thumbs" class="hidden sm:relative flex my-8 overflow-x-auto border border-gray-300 px-2 scroll-smooth">
            @foreach($stack->overlays AS $overlay)
                <div id="{{ $current->id == $overlay->id ? "selectedThumb" : "" }}"
                     class="{{ $current->id == $overlay->id ? 'bg-gray-300' : 'bg-white' }}">
                    <div wire:click="jump({{ $overlay->id }})" class="w-56 h-32 border m-2 mb-0 flex-shrink-0 overflow-hidden text-xs p-2 cursor-pointer select-none leading-normal bg-white {{ $current->id == $overlay->id ? 'border-blue-500' : 'border-gray-300' }}">
                        {{ $overlay->content }}
                    </div>
                    <div class="text-xs ml-2 my-1 {{ $current->id == $overlay->id ? 'text-gray-700' : 'text-gray-400' }}">{{ $loop->index + 1 }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
