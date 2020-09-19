<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.stacks.index', [
            'stacks' => team()->stacks,
        ]);
    }
}
