<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
        <h1 class="text-3xl font-semibold">{{ $stack->title }}</h1>
    </div>

    <div class="flex flex-col justify-center lg:flex-row lg:justify-between items-center">
        <div class="my-6 w-112 h-64 xl:w-144 xl:h-80 border border-gray-500 relative overflow-auto">
            <textarea wire:model.debounce.300ms="input" class="absolute inset-0 w-full h-full p-6"></textarea>
        </div>
        <button class="h-8 w-8 border border-gray-400 rounded">
            <i class="fa fa-eye text-gray-700"></i>
        </button>
        <div class="my-6 w-112 h-64 xl:w-144 xl:h-80 border border-gray-300 relative">
            <iframe src="" class="absolute inset-0 w-full h-full" border="0"></iframe>
        </div>
    </div>

    <div class="flex items-center overflow-x-auto h-32 p-2 border border-gray-300">
        @foreach($stack->overlays AS $overlay)
            <div class="w-40 m-2 p-2 h-22 border border-gray-500 flex-shrink-0 overflow-hidden text-xs">
                {{ $overlay->content }}
            </div>
        @endforeach
    </div>
</div>
