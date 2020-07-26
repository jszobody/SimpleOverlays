<?php

namespace App\Http\Livewire\Stacks;

use App\Jobs\CacheOverlay;
use App\Stack;
use Livewire\Component;

class Build extends Component
{
    /** @var Stack */
    public $stack;

    public $cachedCount;
    public $pendingCount;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->poll();
    }

    public function dispatch()
    {
        $this->stack->overlays->each->cache();
    }

    public function poll()
    {
        $this->cachedCount = $this->stack->overlays->filter->cached->count();
        $this->pendingCount = $this->stack->overlays->count() - $this->cachedCount;
    }

    public function render()
    {
        return view('livewire.stacks.build');
    }

    public function zip()
    {
        return redirect()->to(route('zip-stack', ['stack' => $this->stack]));
    }
}
