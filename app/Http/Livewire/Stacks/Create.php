<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $theme;
    public $occurs;
    public $transformations = [];

    public function mount()
    {
        $this->theme = team()->themes->first()->id;
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required',
        ]);

        $stack = team()->stacks()->create([
            'title' => $this->title,
            'theme_id' => $this->theme,
            'occurs_at' => $this->occurs ? Carbon::parse($this->occurs) : null,
        ]);

        $stack->transformations()->sync($this->transformations);

        return redirect()->to(route('edit-stack', ['stack' => $stack]));
    }

    public function render()
    {
        return view('livewire.stacks.create');
    }
}
