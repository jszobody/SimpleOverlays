<?php

namespace App\Http\Livewire\Stacks;

use App\Overlay;
use App\Session;
use App\Stack;
use Livewire\Component;

class Present extends Component
{
    /** @var Stack */
    public $stack;

    /** @var Session */
    public $session;

    /** @var Overlay */
    public $current;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;

        if (request('session')) {
            $this->session = $stack->sessions()->where('id', request('session'))->first();
        } else {
            $this->session = $stack->sessions()->first() ?? $stack->sessions()->create();
        }

        $this->current = $this->session->overlay;
    }

    public function render()
    {
        return view('livewire.stacks.present');
    }

    public function toggle()
    {
        $this->session->toggle();
    }

    public function jump($overlayId)
    {
        $this->session->update(['overlay_id' => $overlayId]);
        $this->current = $this->stack->overlays->where('id', $overlayId)->first();
    }
}
