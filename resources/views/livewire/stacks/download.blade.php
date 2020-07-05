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
        @include("stacks._nav", ['selected' => "download"])
    </div>

    <div class="md:grid md:grid-cols-2 gap-4 md:my-12">
        <div wire:click="zip()" class="rounded border border-gray-200 flex items-center p-6 cursor-pointer hover:shadow-lg">
            <i class="fad fa-file-archive text-5xl mr-6 text-gray-500"></i>
            <div>
                <div class="text-xl mb-2">Download as Zip</div>
                <div class="text-gray-700 text-sm">With all overlays as numbered PNG images.</div>
            </div>
        </div>
    </div>
</div>
