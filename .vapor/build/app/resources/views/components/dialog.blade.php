@props(['title', 'icon', 'id' => null, 'size' => null, 'align' => 'left'])

<x-modal :id="$id" :size="$size" {{ $attributes }}>
    <div class="px-6 py-6 text-center {{ $align == 'left' ? 'sm:flex sm:text-left' : '' }}">
        <div class="my-2 {{ $align == 'left' ? 'sm:mr-4' : '' }}">
            <i class="{{ $icon }}"></i>
        </div>
        <div>
            <div class="">
                <div class="text-lg font-semibold my-3">
                    {{ $title }}
                </div>

                <div class="text-sm leading-5 text-gray-500">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    @isset($footer)
        <div class="px-6 -pt-2 pb-6 sm:text-right">
            {{ $footer }}
        </div>
    @endif
</x-modal>
