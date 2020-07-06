<div class="border-b border-gray-300 mb-8">

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <h1 class="text-3xl font-semibold">{{ $stack->title }} </h1>
            <div class="text-gray-500 ml-4"><i
                    class="fad fa-layer-group"></i> {{ $stack->overlays->count() }} {{ Str::plural('overlay', $stack->overlays->count()) }}
            </div>
        </div>
    </div>

    <div class="flex">
        <a href="{{ route('edit-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "edit" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm">Edit</a>
        <a href="{{ route('preview-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "preview" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Preview</a>
        <a href="{{ route('download-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "download" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Download</a>
        <a href="{{ route('present-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "present" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Present</a>

    </div>

</div>
