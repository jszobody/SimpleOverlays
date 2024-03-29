<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Category;
use App\Models\Stack;
use Livewire\Component;

class Index extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.stacks.index', [
            'stacks' => $this->category->stacks()
                ->active()->withCount('overlays')
                ->orderBy('occurs_at', 'DESC')
                ->orderBy('title')
                ->get(),
        ]);
    }
}
