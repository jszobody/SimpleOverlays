<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10">
    @include("stacks._header", ['selected' => "download"])

    <div class="p-12 mb-6 flex">
        @if($pendingCount)
            <div class="w-1/2 text-xl pr-8" wire:init="dispatch" wire:poll="poll">
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
        @else
            <div class="w-1/2 text-xl pr-8">
                <p class="my-4">All set! You have a shiny new set of overlay images all built and ready to download.</p>
                <p class="my-8">
                    <i class="fad fa-file-archive text-gray-500 mr-1"></i>
                    <a href="{{ route('zip-stack', ['stack' => $stack]) }}" class="text-blue-500 font-bold">Download zip</a>
                </p>
            </div>
        @endif

        <img src="{{ asset('images/undraw_factory_dy0a.svg') }}" class="w-1/2"/>
    </div>
</div>
