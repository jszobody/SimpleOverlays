<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
        <h1 class="text-3xl font-semibold">Teams</h1>
        <a href="{{ route('create-team') }}" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Team</a>
    </div>

    <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-4">
        @foreach($teams as $team)
            <a href="{{ route('edit-team', ['team' => $team]) }}" class="text-center rounded shadow hover:shadow-lg px-4 py-8 border border-gray-200 hover:border-blue-400">
                <i class="fad fa-users text-gray-400 text-5xl"></i>
                <h2 class="font-semibold text-gray-700 text-lg mt-4">{{ $team->name }}</h2>
                <div class="text-gray-500">{{ $team->users->count() }} {{ Str::plural('member', $team->users->count()) }}</div>
                <div class="text-gray-400 text-sm">Owned by <span class="font-bold">{{ $team->owner_id == user()->id ? "you" : $team->owner->name }}</span></div>
            </a>
        @endforeach
    </div>
</div>
