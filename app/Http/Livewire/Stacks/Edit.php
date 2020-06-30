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
            $this->current = $stack->overlays()->where('id', request('selected'))->first();
        } else {
            $this->current = $stack->overlays()->first() ?? $stack->overlays()->create([
                'layout' => $stack->theme->default_layout,
                'size'   => $stack->theme->default_size,
            ]);
        }

        $this->stack = $stack;

        $this->updateProps();
    }

    public function create()
    {
        $this->current = $this->stack->overlays()->create([
            'layout' => $this->current->layout,
            'size'   => $this->current->size,
        ]);

        $this->updateProps();
        $this->stack->load('overlays');
    }

    public function select( $overlayId )
    {
        $this->current = $this->stack->overlays->where('id', $overlayId)->first();
        $this->updateProps();
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

    protected function updateProps()
    {
        $this->content = $this->current->content;
        $this->layout = $this->current->layout;
        $this->size = $this->current->size;
        $this->selected = $this->current->id;
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

        $this->current->update([
            'content' => Str::substr($this->content, 0, $editorState['selectionStart']) . $replacement . Str::substr($this->content, $editorState['selectionEnd'])
        ]);
        $this->updateProps();

        $this->flash['scrollTop'] = $editorState['scrollTop'];
        $this->flash['selectionStart'] = $editorState['selectionStart'];
        $this->flash['selectionEnd'] = $editorState['selectionStart'] + Str::length($replacement);
    }

    protected function flash( $data )
    {
        $this->flash = array_merge_recursive($this->flash, $data);
    }
}
