<div class="container mx-auto bg-white rounded-lg shadow-lg p-6 md:p-10">
    @include("stacks._header", ['selected' => "download"])

    <div class="p-12 mb-6 flex">
        <div class="text-xl pr-8">
            <p class="my-4">Want to use your overlays offline? You can download a zip of all overlays as transparent PNG images.</p>
            <p class="my-8">
                <i class="fad fa-file-archive text-gray-500 mr-1"></i>
                <a href="{{ route('zip-stack', ['stack' => $stack]) }}" class="text-blue-500 font-bold">Download zip</a>
            </p>
        </div>
        <img src="{{ asset('images/undraw_factory_dy0a.svg') }}" class="w-1/2 hidden lg:block"/>
    </div>
</div>
