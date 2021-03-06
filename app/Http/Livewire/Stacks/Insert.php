<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Overlay;
use App\Models\Stack;
use Livewire\Component;

class Insert extends Component
{
    /** Stack */
    public $stack;

    /** @var Stack[] */
    public $stacks;

    /** @var Stack */
    public $selected;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
    }

    public function select($id)
    {
        $this->selected = $this->stacks()->where('id', $id)->first();
    }

    public function insert()
    {
        $this->emitUp('insertFrom', $this->selected->id);
    }

    public function render()
    {
        $this->stacks = $this->stacks();

        return view('livewire.stacks.insert');
    }

    protected function stacks()
    {
        return team()->stacks()->where('id', '!=', $this->stack->id)->get();
    }
}
