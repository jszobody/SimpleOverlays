@push('head')
    <style>
        {!! $stack->theme->css !!}
    </style>
@endpush
@push('app')
    <script>
        const editor = new TextAreaExtended(document.getElementById('input'), {
            tabs: true,
            onChange: function () {
            @this.set('content', document.getElementById('input').value);
            }
        });

        const scroller = new Scroller(document.getElementById('thumbs'));

        mousetrap(document.getElementById('input')).bind(['command+b', 'ctrl+b'], function (e, combo) {
            editor.wrapSelection("**");
        });

        mousetrap(document.getElementById('input')).bind(['command+i', 'ctrl+i'], function (e, combo) {
            editor.wrapSelection("_");
        });

        mousetrap.bind(['right', 'down'], function (e, combo) {
        @this.call("selectNext");
        });

        mousetrap.bind(['up', 'left'], function (e, combo) {
        @this.call("selectPrevious");
        });

        mousetrap.bind(['ctrl+m'], function (e, combo) {
        @this.call("create");
        });

        mousetrap(document.getElementById('input')).bind(['ctrl+m'], function (e, combo) {
        @this.call("create");
        });

        mousetrap.bind(['esc'], function (e, combo) {
        @this.call("hideAllModals");
        });

        new sortable.Sortable(document.getElementById("thumbs"), {
            animation: 150,
            ghostClass: 'bg-gray-300',
            onSort: function (evt) {
            @this.call("moveToPosition", evt.item.dataset.id, evt.oldIndex > evt.newIndex ? evt.newIndex : evt.newIndex + 1);
            }
        });

        updatePreviewZoom();
        window.addEventListener('resize', updatePreviewZoom);

        function updatePreviewZoom() {
            document.getElementById('preview').style.zoom = document.getElementById('preview-shim').offsetWidth / 1920;
        }

        document.addEventListener('DOMContentLoaded', function () {
            scroller.scrollIntoView(document.getElementById("selectedThumb"));
        });

        var thumbScrollPosition = 0;
        document.addEventListener("livewire:load", function (event) {
            window.livewire.hook('beforeDomUpdate', function () {
                thumbScrollPosition = document.getElementById("thumbs").scrollTop;
            });

            window.livewire.hook('afterDomUpdate', function () {
                updatePreviewZoom();

                document.getElementById("thumbs").classList.remove('scroll-smooth');
                document.getElementById("thumbs").scrollTop = thumbScrollPosition;
                document.getElementById("thumbs").classList.add('scroll-smooth');

                setTimeout(function () {
                    scroller.scrollIntoView(document.getElementById("selectedThumb"));

                    if (@this.data.temp.focus == true) {
                        document.getElementById("input").focus();
                    }

                }, 200);
            });
        });
    </script>
@endpush

<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10" x-data="{ showInsertDialog: false }">
    @include("stacks._header", ['selected' => "edit"])

    <div class="relative pl-8">
        <aside id="sidebar" class="absolute top-0 left-0 bottom-0 w-64 flex flex-col">
            <div id="thumbs-toolbar" class="flex justify-between pb-2 text-gray-700">
                <div class="flex">
                    <a wire:click="create()"
                       class="p-2 mr-1 bg-blue-500 hover:bg-blue-700 text-white rounded h-6 flex items-center justify-center cursor-pointer text-sm"><i
                            class="fad fa-layer-plus mr-1"></i> New</a>
                    <a wire:click="showModal('insertStack')"
                       class="p-2 bg-white border border-gray-300 hover:border-blue-700 text-gray-700 hover:text-blue-500 rounded h-6 flex items-center justify-center cursor-pointer text-sm"><i
                            class="fad fa-download mr-1"></i> Insert</a>
                </div>
                <a wire:click="delete()"
                   class="p-1 text-gray-500 hover:text-red-500 border border-white hover:border-red-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i
                        class="fad fa-trash"></i></a>
            </div>

            <div id="thumbs"
                 class="relative flex flex-grow-1 flex-col items-center overflow-y-auto border border-gray-300 scroll-smooth">
                @foreach($stack->overlays AS $overlay)
                    <div wire:click="select({{ $overlay->id }}, false)"
                         id="{{ $current->id == $overlay->id ? "selectedThumb" : "" }}"
                         data-id="{{ $overlay->id }}"
                         class="w-full pr-2 h-32 flex-shrink-0 text-xs cursor-pointer relative select-none leading-normal {{ $current->id == $overlay->id ? 'bg-gray-300' : 'bg-white' }}">
                        <div
                            class="absolute inset-0 overflow-hidden m-2 ml-6 mr-2 p-2 bg-white border {{ $current->id == $overlay->id ? 'border-blue-500' : 'border-gray-300' }} hover:shadow">{{ $overlay->content }}</div>
                        <div
                            class="absolute flex w-6 text-right items-center justify-center left-0 top-0 mt-2 text-xs rounded-full {{ $current->id == $overlay->id ? 'text-gray-700' : 'text-gray-400' }}">{{ $loop->index + 1 }}</div>
                    </div>
                @endforeach
            </div>
        </aside>

        <div id="editor" class="flex flex-col justify-center items-end ml-64">
            <div id="editor-toolbar" class="w-160 xl:w-224 flex justify-start pb-2 text-gray-700">
                <a onclick="editor.wrapSelection('**')"
                   class="p-1 text-gray-600 hover:text-gray-900 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i
                        class="fas fa-bold"></i></a>
                <a onclick="editor.wrapSelection('_')"
                   class="p-1 text-gray-600 hover:text-gray-900 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i
                        class="fas fa-italic"></i></a>
                <div class="border-l border-gray-300 mx-2 my-1"></div>
                <a onclick="editor.formatVerseNumbers()"
                   class="p-1 text-gray-600 hover:text-gray-900 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i
                        class="fas fa-bible"></i></a>
                <a onclick="editor.removeWhitespace()"
                   class="p-1 text-gray-600 hover:text-gray-900 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i
                        class="fas fa-align-slash"></i></a>
            </div>

            <textarea id="input" wire:model.debounce.300ms="content"
                      class="mb-2 w-full h-40 xl:h-56 border border-blue-500 p-6 text-sm xl:text-base"
                      placeholder="Enter your overlay content..."></textarea>

            <div id="preview-toolbar" class="w-160 xl:w-224 flex justify-start py-2 text-gray-700">
                <div class="mr-4">
                    <i class="fad fa-th-large"></i>
                    <select wire:model="layout">
                        @foreach($stack->theme->layouts AS $layout => $label)
                            <option value="{{ $layout }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mr-4">
                    <i class="fad fa-text-size"></i>
                    <select wire:model="size">
                        @foreach($stack->theme->sizes AS $size => $label)
                            <option value="{{ $size }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="preview-wrapper" class="border border-gray-300 relative overflow-hidden text-gray-100 leading-normal">
                <img id="preview-shim" class="w-full" src="{{ asset('images/shim-1920x1080.png') }}"/>
                <div id="preview" class="absolute inset-0">
                    <div class="slide {{ $current->css_classes }} {{ $current->layout }} {{ $current->size }}">
                        <div class="inner">{!! $current->final !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($modals['insertStack'])
        <livewire:stacks.insert :stack="$stack"/>
    @endif
</div>
