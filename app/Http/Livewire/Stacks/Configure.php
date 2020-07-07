<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Configure extends Component
{
    /** @var Stack */
    public $stack;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
    }

    public function render()
    {
        return view('livewire.stacks.configure');
    }
}
