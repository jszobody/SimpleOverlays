<div class="container mx-auto bg-white rounded-lg shadow-lg p-10" x-data="{ showInsertDialog: false }">
    @include("teams._header", ['selected' => "members"])

    <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-4">
        @foreach($team->users AS $user)
            <div class="text-center rounded shadow px-4 py-8 border border-gray-200">
                <i class="fad fa-user text-gray-400 text-5xl"></i>
                <h2 class="font-semibold text-gray-700 text-lg mt-4">{{ $user->name }}</h2>
                <a href="mailto:{{ $user->email }}" class="text-blue-500 hover:text-blue-700 text-sm">{{ $user->email }}</a>
            </div>
        @endforeach
    </div>
</div>
