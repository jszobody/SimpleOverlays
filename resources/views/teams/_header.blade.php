<div class="border-b border-gray-300 mb-8">

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <h1 class="text-3xl font-semibold">{{ $team->name }} </h1>
            <div class="text-gray-500 ml-4"><i
                    class="fad fa-layer-group"></i> {{ $team->users->count() }} {{ Str::plural('member', $team->users->count()) }}
            </div>
        </div>
    </div>

    <div class="flex mt-4">
        <a href="{{ route('edit-team', ['team' => $team]) }}"
           class="{{ $selected == "members" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm">Members</a>
        <a href="{{ route('configure-team', ['team' => $team]) }}"
           class="{{ $selected == "configure" ? "text-black border-solid border-b-4 border-blue-500" : "text-gray-500" }} hover:text-black mr-3 px-4 py-2 font-semibold text-sm ">Settings</a>

    </div>

</div>
