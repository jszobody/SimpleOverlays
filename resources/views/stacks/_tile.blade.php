<a href="{{ route('preview-stack', ['stack' => $stack]) }}"
   class="text-center rounded shadow hover:shadow-lg px-4 py-8 border border-gray-200 hover:border-blue-400 {{ optional($stack->occurs_at)->isToday() ? "border-blue-400" : "" }}">
    <i class="fad {{ $stack->occurs_at ? 'fa-calendar-alt' : 'fa-layer-group' }} text-gray-400 text-5xl"></i>
    <h2 class="font-semibold text-gray-700 text-lg mt-4">{{ $stack->title }}</h2>
    @if($stack->occurs_at)
        <div class="text-gray-600">{{ $stack->occurs_at->format('F j, Y') }}</div>
    @endif
    <div class="text-gray-400 font-bold text-sm">{{ $stack->overlays_count }} {{ Str::plural('overlay', $stack->overlays_count) }}</div>
</a>
