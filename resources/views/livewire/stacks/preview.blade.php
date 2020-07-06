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

    <div x-data="{ png: @json($format == 'png') }" class="flex justify-center items-center my-8">
        <div class="mr-6 w-24 text-right text-gray-700" :class="{ 'text-black font-bold': !png }">HTML</div>
        <span role="checkbox" tabindex="0" @click="png = !png" @keydown.space.prevent="png = !png" wire:click="format('{{ $format == 'png' ? 'html' : 'png' }}')"
              :aria-checked="png.toString()" aria-checked="false" @focus="focused = true" @blur="focused = false"
              class="group relative inline-flex items-center justify-center flex-shrink-0 h-5 w-10 cursor-pointer focus:outline-none">
            <span aria-hidden="true"
                  class="bg-gray-300 absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200"></span>
            <span aria-hidden="true" :class="{ 'translate-x-5': png, 'translate-x-0': !png }"
                class="translate-x-0 absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform group-focus:shadow-outline group-focus:border-blue-300 transition-transform ease-in-out duration-200"></span>
        </span>
        <div class="ml-6 w-24  text-gray-700" :class="{ 'text-black font-bold': png }">PNG images</div>
    </div>

    <div class="lg:grid lg:grid-cols-2 gap-4">
        @foreach($stack->overlays AS $overlay)
            <div class="">

                <div class="relative" style="background-image: url(/images/transparent-pattern.png)">
                    @if($format == 'html')
                        <img class="invisible w-full" src="/images/shim-1920x1080.png"/>
                        <iframe src="{{ route('overlay-preview', ['uuid' => $overlay->uuid, 'cachebust' => microtime()]) }}"
                                class="absolute inset-0 w-full h-full shadow border border-gray-100" border="0" allowTransparency="true"
                                background="transparent"></iframe>
                    @else
                        <img wire:click="edit({{ $overlay->id }})" class="shadow border border-gray-100 cursor-pointer {{ $format == 'html' ? 'invisible' : '' }}"
                             src="{{ route('overlay-png', ['uuid' => $overlay->uuid]) }}"/>
                    @endif
                </div>

                <div class="text-center text-gray-700">{{ $loop->index + 1 }}</div>
            </div>
        @endforeach
    </div>
</div>
