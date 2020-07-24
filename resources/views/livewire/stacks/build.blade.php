<div class="container mx-auto bg-white rounded-lg shadow-lg p-10" wire:init="dispatch" wire:poll>
    @include("stacks._header", ['selected' => "download"])

    <div class="p-12 mb-6 flex">
        <div class="w-1/2 text-xl pr-8">
            <p class="my-4 font-bold">Building...</p>
            <p class="my-4">Converting overlays to PNG images</p>

            <div class="my-6 -mx-1 flex flex-wrap">
                @for($i=0; $i < $cachedCount; $i++)
                    <div class="bg-gray-300 w-8 h-8 mx-1 my-1"></div>
                @endfor
                @for($i=0; $i < $pendingCount; $i++)
                    <div class="border border-gray-300 w-8 h-8 mx-1 my-1"></div>
                @endfor
            </div>
        </div>
        <img src="{{ asset('images/undraw_factory_dy0a.svg') }}" class="w-1/2"/>
    </div>
</div>
