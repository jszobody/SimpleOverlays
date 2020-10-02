<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Overlay;
use App\Models\Session;
use App\Models\Stack;
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

    /** @var array */
    protected $flash = [];

    /** @var array */
    public $temp = [];

    /** @var string */
    public $format;

    public function mount(Stack $stack, $format = 'html')
    {
        $this->stack = $stack;
        $this->format = $format;

        if (request('session')) {
            $this->session = $stack->sessions()->where('id', request('session'))->first();
        } else {
            $this->session = $stack->sessions()->first() ?? $stack->sessions()->create();
        }

        $this->sessionSlug = $this->session->slug;
        $this->setCurrent($this->session->overlay);
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
        $this->setCurrent($this->session->overlay);
    }

    public function toggle()
    {
        $this->session->toggle();
    }

    public function jump($overlayId)
    {
        $this->session->update(['overlay_id' => $overlayId]);
        $this->setCurrent($this->stack->overlays->where('id', $overlayId)->first());
    }

    public function next()
    {
        if (! $this->stack->overlays->after($this->current)) {
            return;
        }

        $this->session->update(['overlay_id' => $this->stack->overlays->after($this->current)->id]);
        $this->setCurrent($this->stack->overlays->after($this->current));
    }

    public function previous()
    {
        if (! $this->stack->overlays->before($this->current)) {
            return;
        }

        $this->session->update(['overlay_id' => $this->stack->overlays->before($this->current)->id]);
        $this->setCurrent($this->stack->overlays->before($this->current));
    }

    protected function setCurrent(Overlay $overlay)
    {
        $this->current = $overlay;
        $this->next = $this->stack->overlays->after($this->current);
    }
}
