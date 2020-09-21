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

        <div @click="showInviteDialog = true"
             class="text-center rounded px-4 py-8 border-2 border-dashed border-gray-300 opacity-50 hover:opacity-100 cursor-pointer">
            <i class="fad fa-user-plus text-gray-400 text-5xl"></i>
            <h2 class="font-semibold text-gray-700 text-lg mt-4">Invite member</h2>
        </div>
    </div>

    <div x-show="showInviteDialog" style="display: none"
         class="fixed bottom-0 inset-x-0 px-4 pb-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center">
        <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75" @click="showInviteDialog = false"></div>
        </div>

        <div x-show="showInviteDialog" x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-sm sm:w-full sm:p-6"
             role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <div class="absolute right-0 top-0 text-gray-500 p-4 cursor-pointer" @click="showInviteDialog = false"><i class="fas fa-times"></i></div>

            <form wire:submit.prevent="invite()">
                <div class="text-center">
                    <i class="fad fa-user-plus text-blue-200 text-4xl"></i>
                    <h3 class="mt-3 text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                        Invite member
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm leading-5 text-gray-500">
                            Provide an email address and we'll invite them to register (if needed) and join this team.
                        </p>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm leading-5 text-gray-500">
                            <x-text-input id="email" type="email" placeholder="Email address" wire:model="email" x-ref="newMemberEmail"></x-text-input>
                        </p>
                    </div>
                </div>

                <div class="mt-3 sm:mt-4">
                <span class="flex w-full rounded-md shadow-sm">

                        <button type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 disabled:bg-gray-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Send invite
                        </button>
                </span>
                </div>
            </form>
        </div>
    </div>
</div>
