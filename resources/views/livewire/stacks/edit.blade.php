@push('head')
<script>
    var thumbScrollPosition = 0;

    document.addEventListener('DOMContentLoaded', updateThumbnailMaxHeight);
    window.addEventListener('resize', updateThumbnailMaxHeight);
    document.addEventListener("livewire:load", function(event) {
        window.livewire.hook('beforeDomUpdate', function() {
            thumbScrollPosition = document.getElementById("thumbs").scrollTop;
        });
        window.livewire.hook('afterDomUpdate', function() {
            updateThumbnailMaxHeight();
            updateEditorInput();
            document.getElementById("thumbs").scrollTop = thumbScrollPosition;
        });
    });

    function updateThumbnailMaxHeight() {
        document.getElementById("thumbs").style.maxHeight = document.getElementById("editor").clientHeight + "px";
    }

    function updateEditorInput() {
        setTimeout(function() {
            var data = @this.data.data;
            console.log(data);

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
        <h1 class="text-3xl font-semibold">{{ $stack->title }}</h1>
    </div>

    <div class="flex items-start relative">
        <div id="thumbs" class="w-64 flex flex-shrink-0 flex-col items-center overflow-y-auto p-2 border border-gray-300">
            @foreach($stack->overlays AS $overlay)
                <div wire:click="select({{ $overlay->id }})"
                     class="w-56 m-2 p-2 h-32 flex-shrink-0 overflow-hidden text-xs hover:shadow cursor-pointer select-none leading-normal border {{ $current->id == $overlay->id ? 'border-blue-500' : 'border-gray-300' }}"
                >
                    {{ $overlay->content }}
                </div>
            @endforeach

                <div wire:click="create()"
                     class="w-56 m-2 p-2 h-24 flex items-center justify-center flex-shrink-0 hover:shadow cursor-pointer select-none border-2 border-dashed border-gray-300 }}"
                >
                    <i class="fad fa-layer-plus text-2xl text-gray-500"></i>
                </div>
        </div>

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
