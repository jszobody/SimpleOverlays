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
        @include("stacks._nav", ['selected' => "preview"])
    </div>

    <div class="md:grid md:grid-cols-2 gap-4">
        @foreach($stack->overlays AS $overlay)
            <div class="">
                <div style="background-image: url(/images/transparent-pattern.png)">
                    <img wire:click="edit({{ $overlay->id }})" class="shadow border border-gray-100 cursor-pointer" src="{{ route('overlay-png', ['uuid' => $overlay->uuid]) }}"/>
                </div>
                <div class="text-center text-gray-700">{{ $loop->index + 1 }}</div>
            </div>
        @endforeach
    </div>
</div>
