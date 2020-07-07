<div class="container mx-auto bg-white rounded-lg shadow-lg p-6">
    @include("stacks._header", ['selected' => "configure"])

    @if($editDetails)
        <div class="max-w-4xl mx-auto my-20 bg-gray-100 rounded px-10 py-4">
            <div class="my-8 flex items-center">
                <label for="title" class="text-lg leading-6 font-medium text-gray-900 w-40 flex-shrink-0">Name</label>
                <div class="rounded-md shadow-sm flex-grow">
                    <input id="title" wire:model.lazy="title"
                           class="form-input w-full block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border-red-500 @enderror"/>
                </div>
            </div>

            <div class="my-8 flex items-center">
                <label for="theme" class="text-lg leading-6 font-medium text-gray-900 w-40 flex-shrink-0">Theme</label>
                <select id="theme" wire:model="theme"
                        class="block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    @foreach(team()->themes AS $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-8 flex">
                <div class="text-lg leading-6 font-medium text-gray-900 w-40 flex-shrink-0">Transformations</div>
                <div class="text-gray-700 flex-grow">
                    @foreach(team()->transformations AS $transformation)
                        <label class="flex items-center">
                            <input wire:model="transformations" id="transformation{{ $transformation->id }}"
                                   type="checkbox" value="{{ $transformation->id }}"
                                   class="form-checkbox h-4 w-4 text-gray-600 transition duration-150 ease-in-out mr-3"> {{ $transformation->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 mb-8">
                <a wire:click="saveDetails()"
                   class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Save</a>
                <a wire:click="$set('editDetails', false)"
                   class="ml-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Cancel</a>
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto my-20 bg-gray-100 rounded px-10 py-4">
            <a wire:click="$set('editDetails', true)">Edit details</a>
        </div>
    @endif
</div>
