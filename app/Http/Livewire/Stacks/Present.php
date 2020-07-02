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

    /** @var string */
    public $sessionSlug;

    /** @var Overlay */
    public $current;

    /** @var Overlay */
    public $next;

    /** @var array  */
    protected $flash = [];

    /** @var array  */
    public $temp = [];

    public function mount(Stack $stack)
    {
        $this->stack = $stack;

        if (request('session')) {
            $this->session = $stack->sessions()->where('id', request('session'))->first();
        } else {
            $this->session = $stack->sessions()->first() ?? $stack->sessions()->create();
        }

        $this->sessionSlug = $this->session->slug;
        $this->current = $this->session->overlay;
        $this->next = $this->stack->overlays->after($this->current);
    }

    public function render()
    {
        $this->temp = $this->flash;

        return view('livewire.stacks.present');
    }

    public function sync()
    {
        $this->update();
        $this->flash['sync'] = true;
    }

    public function update()
    {
        $this->current = $this->session->overlay;
        $this->next = $this->stack->overlays->after($this->current);
    }

    public function toggle()
    {
        $this->session->toggle();
    }

    public function jump($overlayId)
    {
        $this->session->update(['overlay_id' => $overlayId]);
        $this->current = $this->stack->overlays->where('id', $overlayId)->first();
        $this->next = $this->stack->overlays->after($this->current);
    }

    public function next()
    {
        if(!$this->stack->overlays->after($this->current)) {
            return;
        }

        $this->session->update(['overlay_id' => $this->stack->overlays->after($this->current)->id]);
        $this->current = $this->stack->overlays->after($this->current);
        $this->next = $this->stack->overlays->after($this->current);
    }

    public function previous()
    {
        if(!$this->stack->overlays->before($this->current)) {
            return;
        }

        $this->session->update(['overlay_id' => $this->stack->overlays->before($this->current)->id]);
        $this->current = $this->stack->overlays->before($this->current);
        $this->next = $this->stack->overlays->after($this->current);
    }
}
