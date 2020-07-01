<div class="flex">
    <a href="{{ route('edit-stack', ['stack' => $stack]) }}" class="{{ $selected == "edit" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm">Edit</a>
    <a href="{{ route('preview-stack', ['stack' => $stack]) }}" class="{{ $selected == "preview" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Preview</a>
    <a href="{{ route('present-stack', ['stack' => $stack]) }}" class="{{ $selected == "present" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Present</a>
</div>
