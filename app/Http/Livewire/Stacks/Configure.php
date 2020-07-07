<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Configure extends Component
{
    /** @var Stack */
    public $stack;

    /** @var bool */
    public $editDetails = false;

    public $title;
    public $theme;
    public $transformations = [];

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->title = $this->stack->title;
        $this->theme = $this->stack->theme_id;
        $this->transformations = $this->stack->transformations->pluck('id')->map(function($id) { return (string) $id; })->toArray();
    }

    public function saveDetails()
    {
        $this->validate([
            'title' => 'required',
        ]);

        $this->stack->update([
            'title' => $this->title,
            'theme_id' => $this->theme,
        ]);

        $this->stack->transformations()->sync($this->transformations);

        $this->editDetails = false;
    }

    public function render()
    {
        return view('livewire.stacks.configure');
    }
}
