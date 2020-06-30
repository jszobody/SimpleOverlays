@push('head')
<script>
    var thumbScrollPosition = 0;

    document.addEventListener('DOMContentLoaded', function() {
        updateSidebarMaxHeight();

        document.getElementById("thumb{{ $current->id }}").scrollIntoView({
            block:"center",
            behavior: "smooth"
        });

        mousetrap(document.getElementById('input')).bind(['command+b', 'ctrl+b'], function(e, combo) {
            @this.call("wrapSelection", "**", editorInputState());
        });

        mousetrap(document.getElementById('input')).bind(['command+i', 'ctrl+i'], function(e, combo) {
            @this.call("wrapSelection", "_", editorInputState());
        });

        mousetrap.bind(['right','down'], function(e, combo) {
            @this.call("selectNext");
        });

        mousetrap.bind(['up','left'], function(e, combo) {
            @this.call("selectPrevious");
        });

        mousetrap.bind(['ctrl+m'], function(e, combo) {
            @this.call("create");
        });
        mousetrap(document.getElementById('input')).bind(['ctrl+m'], function(e, combo) {
        @this.call("create");
        });

        new sortable.Sortable(document.getElementById("thumbs"), {
            animation: 150,
            filter: '.disable-drag',
            ghostClass: 'bg-gray-300',
            onSort: function (evt) {
                @this.call("moveToPosition", evt.item.dataset.id, evt.oldIndex > evt.newIndex ? evt.newIndex : evt.newIndex+1);
            }
        });

        var textarea = document.getElementById('input');
        textarea.onkeydown = function(event) {
            if (event.keyCode == 9) { //tab was pressed
                var newCaretPosition;
                newCaretPosition = textarea.selectionStart + "\t".length;
                textarea.value = textarea.value.substring(0, textarea.selectionStart) + "\t" + textarea.value.substring(textarea.selectionStart, textarea.value.length);
                textarea.selectionStart = newCaretPosition;
                textarea.selectionEnd = newCaretPosition;
                textarea.focus();
                return false;
            }
        }
    });
    window.addEventListener('resize', updateSidebarMaxHeight);
    document.addEventListener("livewire:load", function(event) {
        window.livewire.hook('beforeDomUpdate', function() {
            thumbScrollPosition = document.getElementById("thumbs").scrollTop;
        });
        window.livewire.hook('afterDomUpdate', function() {
            updateSidebarMaxHeight();
            updateEditorInput();

            //document.getElementById("thumbs").classList.remove('scroll-smooth');
            document.getElementById("thumbs").scrollTop = thumbScrollPosition;
            //document.getElementById("thumbs").classList.add('scroll-smooth');
        });
    });

    function updateSidebarMaxHeight() {
        document.getElementById("sidebar").style.maxHeight = document.getElementById("editor").clientHeight + "px";
    }

    function updateEditorInput() {
        setTimeout(function() {
            var data = @this.data.data;
            console.log(data);

            if(data.focus == true) {
                document.getElementById("input").focus();
            }

            if(typeof data.scrollThumb != "undefined") {
                document.getElementById("thumb" + data.scrollThumb).scrollIntoView({
                    block:"center",
                    behavior: "smooth"
                });
            }

            if(typeof data.selectionStart != "undefined") {
                document.getElementById("input").focus();
                document.getElementById("input").setSelectionRange(data.selectionStart, data.selectionEnd);
            };

            if(typeof data.scrollTop != "undefined") {
                document.getElementById("input").scrollTop = data.scrollTop;
            }
        }, 100);
    }

    function editorInputState()
    {
        return {
            "selectionStart" : document.getElementById('input').selectionStart,
            "selectionEnd" : document.getElementById('input').selectionEnd,
            "scrollTop" : document.getElementById("input").scrollTop
        };
    }
</script>
@endpush

<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
        <div class="flex items-center">
            <h1 class="text-3xl font-semibold">{{ $stack->title }} </h1>
            <div class="text-gray-500 ml-4"><i class="fad fa-layer-group"></i> {{ $stack->overlays->count() }} {{ Str::plural('overlay', $stack->overlays->count()) }}</div>
        </div>
    </div>

    <div class="flex items-start relative">
        <aside id="sidebar" class="w-64 flex flex-col">
            <div id="thumbs-toolbar" class="w-160 xl:w-224 flex justify-start pb-2 text-gray-700">
                <a wire:click="create()" class="p-2 bg-blue-500 hover:bg-blue-700 text-gray-100 rounded h-6 flex items-center justify-center cursor-pointer text-sm"><i class="fas fa-layer-plus mr-1"></i> New</a>
            </div>

            <div id="thumbs" class="flex flex-grow-1 flex-col items-center overflow-y-auto py-2 border border-gray-300 ">
                @foreach($stack->overlays AS $overlay)
    {{--                <div class="h-2 w-full flex-shrink-0 hover:bg-gray-300 cursor-pointer disable-drag"></div>--}}
                    <div wire:click="select({{ $overlay->id }}, false)" id="thumb{{ $overlay->id }}" data-id="{{ $overlay->id }}" class="w-full my-1 pr-2 h-32 flex-shrink-0 text-xs cursor-pointer relative select-none leading-normal {{ $current->id == $overlay->id ? 'bg-gray-200' : 'bg-white' }}">
                        <div class="absolute inset-0 overflow-hidden m-1 ml-6 mr-2 p-2 bg-white border {{ $current->id == $overlay->id ? 'border-blue-500' : 'border-gray-300' }} hover:shadow">{{ $overlay->content }}</div>
                        <div class="absolute flex w-6 text-right items-center justify-center left-0 top-0 mt-1 text-xs rounded-full {{ $current->id == $overlay->id ? 'text-gray-500' : 'text-gray-400' }}">{{ $loop->index + 1 }}</div>
                    </div>
                @endforeach
            </div>
        </aside>

        <div id="editor" class="ml-8 flex-grow flex flex-col justify-center items-end">
            <div id="editor-toolbar" class="w-160 xl:w-224 flex justify-start pb-2 text-gray-700">
                <a wire:click="wrapSelection('**', editorInputState())" class="p-1 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i class="fas fa-bold"></i></a>
                <a wire:click="wrapSelection('_', editorInputState())" class="p-1 border border-white hover:border-blue-500 rounded w-6 h-6 flex items-center justify-center cursor-pointer text-sm"><i class="fas fa-italic"></i></a>
            </div>

            <textarea id="input" wire:model.debounce.300ms="content" class="mb-2 w-160 h-40 xl:w-224 xl:h-56 border border-blue-500 p-6" placeholder="Enter your overlay content..."></textarea>

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
            <div class="w-160 h-88 xl:w-224 xl:h-124 border border-gray-300 relative flex items-center justify-center">
                <i class="fad fa-sync-alt fa-spin text-4xl text-gray-500 block"></i>
                <iframe src="/stacks/{{ $stack->id }}/preview/{{ $current->id }}?cachebust={{ microtime() }}" class="absolute inset-0 w-full h-full" border="0" allowTransparency="true" background="transparent"></iframe>
            </div>
        </div>
    </div>
</div>
