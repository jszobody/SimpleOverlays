<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
        <h1 class="text-3xl font-semibold">Create a new team</h1>
    </div>

    <div class="max-w-3xl mx-auto my-20">
        <div class="my-8">
            <label for="name" class="text-lg leading-6 font-medium text-gray-900">Name</label>
            <div class="mt-2 rounded-md shadow-sm">
                <input id="name" wire:model.lazy="name" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-500 @enderror" />
            </div>
        </div>

        <div class="mt-12">
            <a wire:click="submit()" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Create</a>
        </div>
    </div>
</div>
