<?php

namespace App\Http\Livewire\Stacks;

use App\Overlay;
use App\Stack;
use Livewire\Component;

class Edit extends Component
{
    /** @var Stack */
    public $stack;

    /** @var Overlay */
    public $current;

    /** @var string */
    public $content;

    /** @var string */
    public $layout;

    /** @var string */
    public $size;

    public function mount(Stack $stack)
    {
        $this->current = $stack->overlays()->first() ?? $stack->overlays()->create([
            'layout' => $stack->theme->default_layout,
            'size' => $stack->theme->default_size,
        ]);

        $this->stack = $stack;

        $this->updateProps();
    }

    public function create()
    {
        $this->current = $this->stack->overlays()->create([
            'layout' => $this->stack->theme->default_layout,
            'size' => $this->stack->theme->default_size,
        ]);

        $this->updateProps();
        $this->stack->load('overlays');
    }

    public function select($overlayId)
    {
        $this->current = $this->stack->overlays->where('id', $overlayId)->first();
        $this->updateProps();
    }

    public function updated()
    {
        $this->current->update([
            'content' => $this->content,
            'layout' => $this->layout,
            'size' => $this->size,
        ]);

        $this->stack->load('overlays');
    }

    public function render()
    {
        return view('livewire.stacks.edit');
    }

    protected function updateProps()
    {
        $this->content = $this->current->content;
        $this->layout = $this->current->layout;
        $this->size = $this->current->size;
    }
}
