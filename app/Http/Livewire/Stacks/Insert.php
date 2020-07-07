<?php

namespace App\Http\Livewire\Stacks;

use App\Overlay;
use App\Stack;
use Livewire\Component;

class Insert extends Component
{
    /** Stack */
    public $stack;

    /** @var Stack[] */
    public $stacks;

    /** @var Stack */
    public $selected;

    /** @var Overlay */
    public $current;

    public function mount(Stack $stack, Overlay $current)
    {
        $this->stack = $stack;
        $this->current = $current;
    }

    public function select($id)
    {
        $this->selected = $this->stacks()->where('id', $id)->first();
    }

    public function insert()
    {
        $this->stack->insertFrom($this->selected, $this->current);

        $this->emitUp('updated');
    }

    public function render()
    {
        $this->stacks = $this->stacks();

        return view('livewire.stacks.insert');
    }

    protected function stacks()
    {
        return Stack::where('id', '!=', $this->stack->id)->withCount('overlays')->orderBy('id', 'DESC')->get();
    }
}
