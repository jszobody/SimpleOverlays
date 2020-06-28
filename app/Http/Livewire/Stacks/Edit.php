<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Edit extends Component
{
    /** @var Stack */
    public $stack;

    /** @var string */
    public $input;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->input = "hello world";
    }

    public function render()
    {
        return view('livewire.stacks.edit', [
            'stack' => $this->stack
        ]);
    }
}
