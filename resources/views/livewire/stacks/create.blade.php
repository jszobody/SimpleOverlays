<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
        <h1 class="text-3xl font-semibold">Create a new stack</h1>
    </div>

    <div class="max-w-3xl mx-auto my-20">
        <div class="my-8">
            <label for="title" class="text-lg leading-6 font-medium text-gray-900">Name</label>
            <p class="mt-1 text-sm leading-5 text-gray-500">
                This could be an event name, a project, or a collection you want to re-use later.
            </p>
            <div class="mt-2 rounded-md shadow-sm">
                <input id="title" wire:model.lazy="title" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-500 @enderror" />
            </div>
        </div>

        <div class="my-8">
            <label for="theme" class="text-lg leading-6 font-medium text-gray-900">Theme</label>
            <select id="theme" wire:model="theme"
                    class="mt-2 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                @foreach(team()->themes AS $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-8">
            <div class="text-lg leading-6 font-medium text-gray-900">Transformations</div>
            <p class="mt-1 text-sm leading-5 text-gray-500">
                Selected transformations will be applied to all overlays automatically.
            </p>
            <div class="mt-2 text-gray-700">
                @foreach(team()->transformations AS $transformation)
                    <label class="flex items-center">
                        <input wire:model="transformations" id="transformation{{ $transformation->id }}" type="checkbox" value="{{ $transformation->id }}"
                               class="form-checkbox h-4 w-4 text-gray-600 transition duration-150 ease-in-out mr-3"> {{ $transformation->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mt-12">
            <a wire:click="submit()" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Create</a>
        </div>
    </div>
</div>
