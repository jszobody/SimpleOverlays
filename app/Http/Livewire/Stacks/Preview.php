<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Preview extends Component
{
    /** @var Stack */
    public $stack;

    /** @var string */
    public $format;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->format = "html";
    }

    public function format($format)
    {
        $this->format = $format;
    }

    public function render()
    {
        return view('livewire.stacks.preview');
    }

    public function edit($overlayId)
    {
        return redirect(
            route('edit-stack', ['stack' => $this->stack, 'selected' => $overlayId])
        );
    }
}
