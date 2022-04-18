<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10">
    @include("teams._header", ['selected' => "configure"])

    @if($editDetails)
        <div class="max-w-4xl mx-auto my-10 bg-gray-100 rounded p-10">
            <div class="text-xl font-bold mb-2">Team details</div>

            <div class="my-8 flex items-center">
                <label for="name" class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Name</label>
                <div class="rounded-md shadow-sm flex-grow">
                    <input id="name" wire:model.lazy="name"
                           class="form-input w-full block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-500 @enderror"/>
                </div>
            </div>

            <div class="mt-12 mb-8">
                <a wire:click="saveDetails()"
                   class="mr-1 bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Save</a>
                <a wire:click="$set('editDetails', false)"
                   class="mr-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Cancel</a>
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto my-10 bg-gray-100 rounded p-10">
            <div class="text-xl font-bold mb-2">Team details</div>

            <div class="my-6 flex items-center">
                <label for="title" class="text-lg leading-6 text-gray-900 w-56 flex-shrink-0">Name</label>
                <div class="flex-grow font-medium">{{ $name }}</div>
            </div>

            <a wire:click="$set('editDetails', true)"
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Edit details</a>
        </div>
    @endif
</div>
