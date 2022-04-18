<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Overlay;
use App\Models\Stack;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $theme;
    public $occurs;
    public $category;
    public $categories;
    public $template;
    public $transformations = [];

    public function mount()
    {
        $this->theme = team()->themes->first()->id;
        $this->categories = team()->categories->toArray();
        $this->category = $this->categories[0]['id'];
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required',
        ]);

        $stack = team()->stacks()->create([
            'title' => $this->title,
            'theme_id' => $this->theme,
            'category_id' => $this->category,
            'occurs_at' => $this->occurs ? Carbon::parse($this->occurs) : null,
        ]);

        $stack->transformations()->sync($this->transformations);

        if($this->template) {
            foreach (Stack::find($this->template)->overlays as $overlay) {
                $stack->overlays()->save($overlay->replicate(['uuid']));
            }
        }

        return $this->redirectRoute('edit-stack', ['stack' => $stack]);
    }

    public function render()
    {
        return view('livewire.stacks.create', [
            'templates' => team()->templates
        ]);
    }
}
