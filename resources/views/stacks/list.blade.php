@extends('layouts.app')

@section('content')
    <div class="container mx-auto bg-white rounded-lg shadow-lg p-10">
        <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-8">
            <h1 class="text-3xl font-semibold">Stacks</h1>
            <a href="/stacks/create" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Stack</a>
        </div>

        @if(!count($stacks))
            <div class="p-12 flex">
                <div class="w-1/2 text-xl pr-8">
                    <p class="my-4">Stacks are how you organize your content overlays.</p>
                    <p class="my-4">Create a stack for an event, a project, or even just a collection that you may want to re-use later in other stacks.</p>
                    <p class="my-8"><a href="/stacks/create" class="text-blue-500 font-bold">Create your first stack...</a></p>
                </div>
                <img src="/images/undraw_taking_notes_tjaf.svg" class="w-1/2"/>
            </div>
        @endif

        <div class="sm:flex flex-wrap">
            @foreach($stacks AS $stack)
                <a href="/stacks/{{ $stack->id }}" class="text-center rounded shadow hover:shadow-lg px-4 py-8 sm:w-1/2 lg:w-1/3 xl:w-1/4 border border-gray-200 hover:border-blue-400">
                    <i class="fad fa-layer-group text-gray-400 text-5xl"></i>
                    <h2 class="font-semibold text-gray-700 text-lg mt-4">{{ $stack->title }}</h2>
                    <div class="text-gray-600">{{ $stack->overlays_count }} {{ Str::plural('overlay', $stack->overlays_count) }}</div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
