@push('head')
    <style>
        {!! $stack->theme->css !!}
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', updatePreviewZoom);
        window.addEventListener('resize', updatePreviewZoom);
        function updatePreviewZoom() {
            let zoom = document.getElementsByClassName('preview-shim')[0].offsetWidth / 1920;
            for (let preview of document.getElementsByClassName('preview')) {
                preview.style.zoom = zoom;
            }
        }
    </script>
@endpush
<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    @include("stacks._header", ['selected' => "preview"])

{{--    <div x-data="{ png: @json($format == 'png') }" class="flex justify-center items-center my-8">--}}
{{--        <div class="mr-6 w-24 text-right text-gray-700" :class="{ 'text-black font-bold': !png }">HTML</div>--}}
{{--        <span role="checkbox" tabindex="0" @click="png = !png" @keydown.space.prevent="png = !png" wire:click="format('{{ $format == 'png' ? 'html' : 'png' }}')"--}}
{{--              :aria-checked="png.toString()" aria-checked="false" @focus="focused = true" @blur="focused = false"--}}
{{--              class="group relative inline-flex items-center justify-center flex-shrink-0 h-5 w-10 cursor-pointer focus:outline-none">--}}
{{--            <span aria-hidden="true"--}}
{{--                  class="bg-gray-300 absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200"></span>--}}
{{--            <span aria-hidden="true" :class="{ 'translate-x-5': png, 'translate-x-0': !png }"--}}
{{--                class="translate-x-0 absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform group-focus:shadow-outline group-focus:border-blue-300 transition-transform ease-in-out duration-200"></span>--}}
{{--        </span>--}}
{{--        <div class="ml-6 w-24  text-gray-700" :class="{ 'text-black font-bold': png }">PNG images</div>--}}
{{--    </div>--}}

    <div class="lg:grid lg:grid-cols-2 gap-4">
        @foreach($stack->overlays AS $overlay)
            <div class="">
                <div class="preview-container border border-gray-300 relative overflow-hidden text-gray-100 leading-normal" style="background-image: url({{ asset('images/transparent-pattern.png') }})">
                    <img class="preview-shim w-full" src="{{ asset('images/shim-1920x1080.png') }}"/>
                    <div class="preview absolute inset-0">
                        <div class="slide {{ $overlay->css_classes }} {{ $overlay->layout }} {{ $overlay->size }}">
                            <div class="inner">{!! $overlay->final !!}</div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-gray-700">{{ $loop->index + 1 }}</div>
            </div>
        @endforeach
    </div>
</div>
