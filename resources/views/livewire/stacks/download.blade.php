<div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
    @include("stacks._header", ['selected' => "download"])

    <div class="md:grid md:grid-cols-2 gap-4 md:my-12">
        <div wire:click="zip()" class="rounded border border-gray-200 flex items-center p-6 cursor-pointer hover:shadow-lg">
            <i class="fad fa-file-archive text-5xl mr-6 text-gray-500"></i>
            <div>
                <div class="text-xl mb-2">Download as Zip</div>
                <div class="text-gray-700 text-sm">With all overlays as numbered PNG images.</div>
            </div>
        </div>
    </div>
</div>
