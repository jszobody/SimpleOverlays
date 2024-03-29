<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10">
    @include("stacks._header", ['selected' => "configure"])

    @if($editDetails)
        <div class="max-w-4xl mx-auto my-10 bg-gray-100 rounded p-10">
            <div class="text-xl font-bold mb-2">Stack details</div>

            <div class="my-8 flex items-center">
                <label for="title" class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Name</label>
                <div class="rounded-md shadow-sm flex-grow">
                    <x-text-input id="title" wire:model="stack.title" :error="$errors->has('stack.title')"></x-text-input>
                </div>
            </div>

            <div class="my-8 flex items-center">
                <label for="title" class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Category</label>
                <div class="flex-grow">
                    <div x-data="{
                        categories: @entangle('categories'),
                        selected: @entangle('category'),
                    }" class="mt-2 grid grid-cols-3 gap-2">
                        <template x-for="category in categories">
                            <div class="rounded-lg p-4 cursor-pointer border" @click="selected = category.id"
                                 :class="selected == category.id ? 'border-blue-500 bg-white shadow' : 'border-gray-300 bg-gray-50 shadow-sm'">
                                <div x-text="category.name" class="font-medium"></div>
                                <div x-text="category.description" class="text-sm text-gray-500"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="my-8 flex items-center">
                <label for="occurs" class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Date</label>
                <div class="rounded-md shadow-sm flex-grow relative">
                    <input id="occurs" wire:model="occurs"
                           class="form-input w-full block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 pr-10"/>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400" wire:click="$set('occurs', null)">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
            <script>
                const fp = flatpickr(document.getElementById("occurs"), {dateFormat: 'F j, Y'});
            </script>

            <div class="my-8 flex items-center">
                <label for="theme" class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Theme</label>
                <select id="theme" wire:model="stack.theme_id"
                        class="block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    @foreach(team()->themes AS $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-8 flex">
                <div class="text-lg leading-6 font-medium text-gray-900 w-56 flex-shrink-0">Transformations</div>
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
                   class="mr-1 bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Save</a>
                <a wire:click="cancel()"
                   class="mr-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Cancel</a>
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto my-10 bg-gray-100 rounded p-10">
            <div class="text-xl font-bold mb-2">Stack details</div>

            <div class="my-6 flex items-center">
                <label for="title" class="text-lg leading-6 text-gray-900 w-56 flex-shrink-0">Name</label>
                <div class="flex-grow font-medium">{{ $stack->title }}</div>
            </div>

            <div class="my-6 flex items-center">
                <label for="title" class="text-lg leading-6 text-gray-900 w-56 flex-shrink-0">Category</label>
                <div class="flex-grow font-medium">{{ $stack->category->name }}</div>
            </div>

            @if($stack->occurs_at)
                <div class="my-6 flex items-center">
                    <label for="theme" class="text-lg leading-6  text-gray-900 w-56 flex-shrink-0">Date</label>
                    <div class="flex-grow font-medium">{{ $stack->occurs_at->format('F j, Y') }}</div>
                </div>
            @endif

            <div class="my-6 flex items-center">
                <label for="theme" class="text-lg leading-6  text-gray-900 w-56 flex-shrink-0">Theme</label>
                <div class="flex-grow font-medium">{{ $stack->theme->name }}</div>
            </div>

            <div class="my-6 flex">
                <div class="text-lg leading-6  text-gray-900 w-56 flex-shrink-0">Transformations</div>
                <div class="flex-grow font-medium">
                    @foreach($stack->transformations AS $transformation)
                        <div>{{ $transformation->name }}</div>
                    @endforeach
                </div>
            </div>

            <a wire:click="$set('editDetails', true)"
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Edit details</a>
        </div>
    @endif

    <div class="max-w-4xl mx-auto my-10 bg-gray-100 rounded p-10">
        <div class="text-xl font-bold">Archive</div>
        <div class="my-8">
            Finished with these overlays? Archive this stack to remove it from the main list.
        </div>
        <div class="pt-2">
        <a wire:click="archive()"
           class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">Archive</a>
        </div>
    </div>
</div>
