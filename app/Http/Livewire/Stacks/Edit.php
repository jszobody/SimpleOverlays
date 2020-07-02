<?php

namespace App\Http\Livewire\Stacks;

use App\Overlay;
use App\Stack;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    /** @var Stack */
    public $stack;

    /** @var Overlay */
    public $current;

    /** @var string */
    public $content;

    /** @var string */
    public $layout;

    /** @var string */
    public $size;

    /** @var array */
    public $temp = [];

    /** @var array */
    protected $flash = [];

    /** @var int */
    public $selected = 0;

    /** @var string[] */
    protected $updatesQueryString = ['selected'];

    public function mount(Stack $stack, $selected = null)
    {
        if (request('selected')) {
            $this->setCurrent($stack->overlays()->where('id', request('selected'))->first());
        } else {
            $this->setCurrent($stack->overlays()->first() ?? $stack->overlays()->create([
                    'layout' => $stack->theme->default_layout,
                    'size'   => $stack->theme->default_size,
                ]));
        }

        $this->stack = $stack;
    }

    public function create()
    {
        $old = $this->current;

        $this->setCurrent($this->stack->overlays()->create([
            'layout' => $this->current->layout,
            'size'   => $this->current->size,
        ]));

        $this->current->moveAfter($old);
        $this->stack->load('overlays');
        $this->flash['focus'] = true;
    }

    public function delete()
    {
        $this->current->delete();

        if ($this->getCurrentIndex() + 1 < $this->stack->overlays->count()) {
            $this->setCurrent($this->stack->overlays->get($this->getCurrentIndex() + 1));
        } else if ($this->getCurrentIndex() > 0) {
            $this->setCurrent($this->stack->overlays->get($this->getCurrentIndex() - 1));
        } else {
            $this->setCurrent(
                $this->stack->overlays()->create([
                    'layout' => $this->stack->theme->default_layout,
                    'size'   => $this->stack->theme->default_size,
                ])
            );
        }

        $this->stack->load('overlays');
    }

    public function updated()
    {
        $this->current->update([
            'content' => trim($this->content),
            'layout'  => $this->layout,
            'size'    => $this->size,
        ]);

        $this->stack->load('overlays');
    }

    public function render()
    {
        $this->temp = $this->flash;

        return view('livewire.stacks.edit');
    }

    public function select($overlayId)
    {
        $this->setCurrent($this->stack->overlays->where('id', $overlayId)->first(), false);
    }

    public function selectNext()
    {
        if ($this->getCurrentIndex() + 1 < $this->stack->overlays->count()) {
            $this->setCurrent($this->stack->overlays->get($this->getCurrentIndex() + 1));
        }
    }

    public function selectPrevious()
    {
        if ($this->getCurrentIndex() > 0) {
            $this->setCurrent($this->stack->overlays->get($this->getCurrentIndex() - 1));
        }
    }

    public function moveToPosition($id, $position)
    {
        $this->stack->overlays()->where('id', $id)->first()->moveToPosition($position);
        $this->stack->load('overlays');
    }

    protected function getCurrentIndex()
    {
        foreach ($this->stack->overlays AS $index => $overlay) {
            if ($overlay->id == $this->current->id) {
                return $index;
            }
        };
    }

    protected function setCurrent(Overlay $overlay, $scroll = true)
    {
        $this->current = $overlay;
        $this->content = $this->current->content;
        $this->layout = $this->current->layout;
        $this->size = $this->current->size;
        $this->selected = $this->current->id;

        if ($scroll) {
            $this->flash['scrollThumb'] = $this->current->id;
        }
    }

    protected function updateContent($content)
    {
        $this->current->update(['content' => $content]);
        $this->content = $this->current->content;
    }
}
