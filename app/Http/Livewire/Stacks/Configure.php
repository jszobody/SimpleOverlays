<?php

namespace App\Http\Livewire\Stacks;

use App\Models\Stack;
use Carbon\Carbon;
use Livewire\Component;

class Configure extends Component
{
    /** @var Stack */
    public $stack;
    public $category;
    public $categories;
    public $occurs;

    protected $rules = [
        'stack.title' => 'required',
    ];

    /** @var bool */
    public $editDetails = false;

    public $transformations = [];

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->occurs = $this->stack->occurs_at ? $this->stack->occurs_at->format('F j, Y') : null;
        $this->theme = $this->stack->theme_id;
        $this->transformations = $this->stack->transformations->pluck('id')->map(function ($id) {
            return (string) $id;
        })->toArray();
        $this->categories = team()->categories->toArray();
        $this->category = $this->stack->category_id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveDetails()
    {
        $this->validate();

        $this->stack->update([
            'occurs_at' => $this->occurs ? Carbon::parse($this->occurs) : null,
            'category_id' => $this->category
        ]);

        $this->stack->transformations()->sync($this->transformations);
        $this->stack->unsetRelations();

        $this->editDetails = false;
    }

    public function cancel()
    {
        $this->stack = $this->stack->fresh();
        $this->editDetails = false;
    }

    public function archive()
    {
        $this->stack->archive();

        return $this->redirectRoute('list-stacks', ['category' => $this->stack->category_id]);
    }

    public function render()
    {
        return view('livewire.stacks.configure');
    }
}
