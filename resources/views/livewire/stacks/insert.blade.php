<div x-data="{show: false}" x-init="$nextTick(() => show = true)" x-show="show"
     class="hidden fixed bottom-0 inset-x-0 px-4 pb-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center">
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75" @click="show = false" wire:click="$emitUp('hideModal', 'insertStack')"></div>
    </div>

    <div x-show="show" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6"
         role="dialog" aria-modal="true" aria-labelledby="modal-headline">

        <div class="absolute right-0 top-0 text-gray-500 p-4 cursor-pointer" @click="show = false" wire:click="$emitUp('hideModal', 'insertStack')"><i class="fas fa-times"></i></div>

        <div>
            <div class="">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Insert another stack
                </h3>
                <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500">
                        All overlays from the selected stack will be copied to your current stack.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-5 overflow-y-auto h-64 px-4">
            @foreach($stacks AS $stack)
                <div wire:click="select({{ $stack->id }})" class="rounded shadow-sm hover:shadow px-4 py-2 my-2 border flex items-center justify-between cursor-pointer {{ $selected && $selected->id == $stack->id ? 'border-blue-400' : 'border-gray-200 hover:border-blue-400' }}">
                    <div class="text-gray-700 {{ $selected && $selected->id == $stack->id ? 'font-semibold' : '' }}">{{ $stack->title }}</div>
                    <div class="text-gray-500 text-sm">{{ $stack->overlays_count }} <i class="fad fa-layer-group text-gray-400 ml-1"></i></div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 sm:mt-6">
            <span class="flex w-full rounded-md shadow-sm">

                    <button type="button" {{ $selected ? '' : 'disabled' }} wire:click="insert()" @click="show = false"
                          class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 disabled:bg-gray-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        @if($selected)
                            Copy {{ $selected->overlays_count }} {{ Str::plural('overlay', $selected->overlays_count) }} and insert
                        @else
                            Select a stack to copy
                        @endif
                    </button>
            </span>
        </div>
    </div>
</div>
