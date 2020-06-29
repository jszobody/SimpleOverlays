<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Livewire\Component;

class Create extends Component
{
    public $title;

    public $theme;

    public function mount()
    {
        $this->theme = user()->themes->first()->id;
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required',
        ]);

        $stack = Stack::create([
            'title' => $this->title,
            'theme_id' => $this->theme,
        ]);

        return redirect()->to('/stacks/' . $stack->id);
    }

    public function render()
    {
        return view('livewire.stacks.create');
    }
}
