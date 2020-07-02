@push('app')
    <script>
        let pusher = Echo.join('session.{{ $session->slug }}');

        pusher.listenForWhisper('update', (e) => {
            @this.call('sync');
        });

        mousetrap.bind(['right', 'down', 'space'], function (e, combo) {
        @this.call('next');
        });

        mousetrap.bind(['left', 'up'], function (e, combo) {
        @this.call('previous');
        });

        mousetrap.bind(['b'], function (e, combo) {
        @this.call('toggle');
        });

        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('afterDomUpdate', function () {
                if(typeof @this.data.temp.sync == 'undefined') {
                    pusher.whisper('update', {});
                }
            });
        });
    </script>
@endpush
<div>
    @foreach($session->stack->overlays AS $overlay)
        <img class="{{ $current->id == $overlay->id && $session->visible ? "w-full" : "hidden" }}" src="{{ route('overlay-png', ['uuid' => $overlay->uuid]) }}"/>
    @endforeach
</div>
