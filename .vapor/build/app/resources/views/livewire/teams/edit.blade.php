<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10" x-data="{ showInviteDialog: false }">
    @include("teams._header", ['selected' => "members"])

    <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-4">
        @foreach($team->users AS $user)
            <div class="text-center rounded shadow px-4 py-8 border border-gray-200">
                <i class="fad fa-user text-gray-400 text-5xl"></i>
                <h2 class="font-semibold text-gray-700 text-lg mt-4">{{ $user->name }}</h2>
                <a href="mailto:{{ $user->email }}" class="text-blue-500 hover:text-blue-700 text-sm">{{ $user->email }}</a>
            </div>
        @endforeach

        <div wire:click="displayInviteDialog()"
             class="text-center rounded px-4 py-8 border-2 border-dashed border-gray-300 opacity-50 hover:opacity-100 cursor-pointer">
            <i class="fad fa-user-plus text-gray-400 text-5xl"></i>
            <h2 class="font-semibold text-gray-700 text-lg mt-4">Invite member</h2>
        </div>
    </div>

    <x-dialog wire:model="displayingInviteDialog" title="Invite member" size="sm" align="center" icon="fad fa-user-plus text-blue-200 text-4xl">
        <form wire:submit.prevent="invite()">
            <div>Provide an email address and we'll invite them to register (if needed) and join this team.</div>
            <div class="my-5">
                <x-error for="email" class="my-2" />
                <x-text-input id="email" type="email" placeholder="Email address" wire:model="email" x-ref="newMemberEmail"></x-text-input>
            </div>


            <span class="flex w-full rounded-md shadow-sm">
                <button type="submit"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 disabled:bg-gray-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Send invite
                </button>
            </span>
        </form>

        <x-slot name="trigger">
            <div @click="on = true"
                 class="text-center rounded px-4 py-8 border-2 border-dashed border-gray-300 opacity-50 hover:opacity-100 cursor-pointer">
                <i class="fad fa-user-plus text-gray-400 text-5xl"></i>
                <h2 class="font-semibold text-gray-700 text-lg mt-4">Invite member</h2>
            </div>
        </x-slot>
    </x-dialog>
</div>
