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
    public $data = [];

    /** @var array */
    protected $flash = [];

    /** @var int */
    public $selected = 0;

    /** @var string[] */
    protected $updatesQueryString = ['selected'];

    public function mount( Stack $stack, $selected = null )
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
        $this->setCurrent($this->stack->overlays()->create([
            'layout' => $this->current->layout,
            'size'   => $this->current->size,
        ]));

        $this->stack->load('overlays');
        $this->flash['focus'] = true;
    }

    public function select( $overlayId )
    {
        $this->setCurrent($this->stack->overlays->where('id', $overlayId)->first());
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
        $this->data = $this->flash;

        return view('livewire.stacks.edit');
    }

    public function wrapSelection( $wrap, $editorState )
    {
        if ($editorState['selectionStart'] == $editorState['selectionEnd']) {
            return;
        }

        $selected = Str::substr($this->content, $editorState['selectionStart'], $editorState['selectionEnd'] - $editorState['selectionStart']);

        if (Str::startsWith($selected, $wrap) && Str::endsWith($selected, $wrap)) {
            $replacement = Str::substr($selected, Str::length($wrap), 0 - Str::length($wrap));
        } else {
            $replacement = $wrap . $selected . $wrap;
        }

        $this->updateContent(
            Str::substr($this->content, 0, $editorState['selectionStart']) . $replacement . Str::substr($this->content, $editorState['selectionEnd'])
        );

        $this->flash['scrollTop'] = $editorState['scrollTop'];
        $this->flash['selectionStart'] = $editorState['selectionStart'];
        $this->flash['selectionEnd'] = $editorState['selectionStart'] + Str::length($replacement);
        $this->stack->load('overlays');
    }

    public function selectNext()
    {
        $iterator = $this->iterateToCurrent();

        if($next = next($iterator)) {
            $this->setCurrent($next);
        }
    }

    public function selectPrevious()
    {
        $iterator = $this->iterateToCurrent();

        if($prev = prev($iterator)) {
            $this->setCurrent($prev);
        }
    }

    public function moveToPosition($id, $position)
    {
        $this->stack->overlays()->where('id', $id)->first()->moveToPosition($position);
        $this->stack->load('overlays');
    }

    protected function iterateToCurrent()
    {
        $iterator = $this->stack->overlays->getIterator();

        while(current($iterator)->id != $this->current->id) {
            next($iterator);
        }

        return $iterator;
    }

    protected function flash( $data )
    {
        $this->flash = array_merge_recursive($this->flash, $data);
    }

    protected function setCurrent(Overlay $overlay)
    {
        $this->current = $overlay;
        $this->content = $this->current->content;
        $this->layout = $this->current->layout;
        $this->size = $this->current->size;
        $this->selected = $this->current->id;
        $this->flash['scrollThumb'] = $this->current->id;
    }

    protected function updateContent($content)
    {
        $this->current->update(['content' => $content]);
        $this->content = $this->current->content;
    }
}
