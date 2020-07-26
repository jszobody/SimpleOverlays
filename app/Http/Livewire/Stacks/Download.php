<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Download extends Component
{
    /** @var Stack */
    public $stack;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
    }

    public function render()
    {
        return view('livewire.stacks.download');
    }
}
