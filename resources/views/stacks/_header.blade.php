<div class="border-b border-gray-300 mb-8">

    <div class="flex items-center justify-between">
        <div class="flex flex-wrap items-center">
            <h1 class="w-full md:w-auto text-3xl font-semibold mr-4">{{ $stack->title }} </h1>
            @if($stack->occurs_at)
                <div class="text-gray-500 mr-4"><i
                        class="fad fa-calendar"></i> {{ $stack->occurs_at->format('F j, Y') }}
                </div>
            @endif
            <div class="text-gray-500"><i
                    class="fad fa-layer-group"></i> {{ $stack->overlays->count() }} {{ Str::plural('overlay', $stack->overlays->count()) }}
            </div>
        </div>
    </div>

    <div class="flex mt-4">
        <a href="{{ route('preview-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "preview" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Preview</a>
        <a href="{{ route('edit-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "edit" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm hidden md:inline">Edit</a>
        <a href="{{ route('download-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "download" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm hidden md:inline">Download</a>
        <a href="{{ route('present-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "present" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Present</a>
        <a href="{{ route('configure-stack', ['stack' => $stack]) }}"
           class="{{ $selected == "configure" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Settings</a>

    </div>

</div>
