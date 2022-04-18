<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Category;
use App\Models\Overlay;
use App\Models\Stack;
use Livewire\Component;

class Insert extends Component
{
    public Stack $stack;
    public Stack $selected;
    public Category $category;
    public $filter = '';

    /** @var Stack[] */
    public $stacks;

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->category = team()->categories()->first();
    }

    public function select($id)
    {
        $this->selected = $this->stacks()->where('id', $id)->first();
    }

    public function insert()
    {
        $this->emitUp('insertFrom', $this->selected->id);
    }

    public function render()
    {
        $this->stacks = $this->stacks();

        return view('livewire.stacks.insert');
    }

    protected function stacks()
    {
        return $this->category->stacks()
            ->where('id', '!=', $this->stack->id)
            ->when(!!$this->filter, function($query) {
                $query->where('title','like', '%' . strtolower($this->filter) . '%');
            })
            ->get();
    }

    public function category($category)
    {
        $this->category = Category::find($category);
    }
}
